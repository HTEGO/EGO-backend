<?php
 namespace App\Http\Controllers;

use Illuminate\Http\Request ;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class YouthListController extends Controller {

    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return Response
     */
    public function add(Request $request)
    {
  		$list = $request->input('list');

  		$player = $request->input('player');

  		if(isset($list) && isset($player)){
  			$result = $query = DB::table("youthlistyouthplayer")->insert([
  				["youthlist_id" => $list, "youthplayer_id" => $player]
  			]);
  		} else {
  			$result = false;
  		}


  		return response()->json(["result" => $result]);
    }


    public function youthList(Request $request)
    {
      $list = $request->input('list');

      if( isset($list) ) {
        $query = DB::table("youthlistyouthplayer AS yl")
  			->select(DB::raw("p.id, p.first_name, p.last_name, p.age, p.days, p.specialty, l.position, max(l.stars) stars, yl.youthlist_id list"))
        ->join("youthplayer AS p",'yl.youthplayer_id','=','p.id')
  			->join("youthmatchlineup AS l","l.youthPlayer_id","=","p.id")
        ->groupBy('p.id')
        ->distinct();

        $query->where("yl.youthlist_id", "=", $list );
        $results = $query->get();
      } else {
        return response("Position not defined",404);
      }

      return response()->json($results);
    }

    public function youthBlacklist(Request $request)
    {
      $listIds =  [];
      for($i = 0; $i < 6; $i++){
        $listIds[$i] = $i + 6;
      }

      $query = DB::table("youthlistyouthplayer AS yl")
			->select(DB::raw("p.id, p.first_name, p.last_name, p.age, p.days, p.specialty, l.position, max(l.stars) stars, yl.youthlist_id list"))
      ->join("youthplayer AS p",'yl.youthplayer_id','=','p.id')
			->join("youthmatchlineup AS l","l.youthPlayer_id","=","p.id")
      ->groupBy('p.id')
      ->distinct();

      $query->whereIn("yl.youthlist_id", $listIds);
      $results = $query->get();

      return response()->json($results);
    }

    public function remove(Request $request){
  		$list = $request->input('list');

  		$player = $request->input('player');

  		if(isset($list) && isset($player)){
  			$result = $query = DB::table("youthlistyouthplayer")
          ->where('youthlist_id', $list)
          ->where('youthplayer_id', $player)
          ->delete();
  		} else {
  			$result = false;
        return Response("Position or list not defined",404);
  		}


  		return response()->json(["result" => $result]);
    }

}
