<?php namespace Ego\Http\Controllers;

use Illuminate\Http\Request ;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Ego\Http\Controllers\Controller;

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
  			->select(DB::raw("p.id, p.first_name, p.last_name, p.age, p.days, p.specialty, l.position, max(l.stars) stars"))
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
