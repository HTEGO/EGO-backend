<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request ;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class BestYouthPlayerController extends Controller {

    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return Response
     */
    public function listBestYouthPlayers(Request $request)
    {

    $listId = 0;

		$query = DB::table("youthplayer AS p")
			->select(DB::raw("p.id, p.first_name, p.last_name, p.age, p.days, p.specialty, l.position, l.order, max(l.stars) stars, st.name teamName, l.order, yl.youthlist_id as list"))
			->join("youthmatchlineup AS l","l.youthPlayer_id","=","p.id")
			->join("youthteam AS yot","yot.id","=","p.youthTeam_id")
			->join("seniorteam AS st","st.id","=","seniorTeam_id")
      ->groupBy('p.id')

			->distinct();

		$stars = $request->input('starts');
		$position = $request->input('position');
		$age = $request->input('age');
		$minimunDays = $request->input('minimumDays');
		$maximunDays = $request->input('maximumDays');
		$specialty = $request->input('specialty');

		if(!isset($stars)){
			$query->where("l.stars",">=",4);
		}


		$positionArray = Array();
		if(isset($position)){
			if($position == 'keeper') {
				$query->where("l.position","=",100);
        $listId = 1;
			} elseif ($position == 'defense') {
				$positionArray = [102,103,104];
				$query->whereIn("l.position",$positionArray);
        $listId = 3;
			} elseif ($position == 'wingBack') {
				$positionArray = [101,105];
				$query->whereIn("l.position",$positionArray);
        $listId = 2;
			} elseif ($position == 'inner') {
				$positionArray = [107,108,109];
				$query->whereIn("l.position",$positionArray);
        $listId = 5;
			} elseif ($position == 'winger') {
				$positionArray = [106,110];
				$query->whereIn("l.position",$positionArray);
        $listId = 4;
			} elseif ($position == 'forward') {
				$positionArray = [111,112,113];
				$query->whereIn("l.position",$positionArray);
        $listId = 6;
			} else {
				return response("Position error",400);
			}

      $query->leftJoin('youthlistyouthplayer AS yl', function($join) use ($listId){
        $join->on('yl.youthplayer_id','=','p.id','and')
        ->where('yl.youthlist_id','=',$listId);
      });
		}

		if(isset($age)){
			if(in_array($age,[15,16,17])){
				$query->where("p.age","=",$age);
			} else {
				return response("Age error",400);
			}
		}

		if(isset($minimunDays)){
			$query->where("p.days",">=",$minimunDays);
		}
		if(isset($maximunDays)){
			$query->where("p.days","<=",$maximunDays);
		}

    if(isset($specialty)){
      if($specialty == -1) {
        $query->where('p.specialty','>',0);
      } elseif ($specialty == -2){
        $query->where('p.specialty','=',0);
      } elseif ($specialty > 0){
        $query->where('p.specialty','=',$specialty);
      }
    }
		//$results = DB::select('SELECT p.id, p.first_name, p.last_name, p.age, p.days, p.specialty, l.position, l.order, l.stars FROM youthplayer p INNER JOIN youthmatchlineup l ON l.youthPlayer_id = p.id INNER JOIN youthteam yt ON yt.id = p.youthTeam_id INNER JOIN seniorteam st ON st.id = yt.seniorTeam_id WHERE l.stars >= ?', [4]);

		$players = $query->get();

    // $query->DB::table(

		return response()->json($players);
    }

}
