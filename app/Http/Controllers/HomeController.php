<?php

namespace App\Http\Controllers;

use App\User;
use App\User_like;
use Auth;
use DB;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result =   User::where('id','!=',Auth::id())
                        ->select(
                            DB::raw('*, 
                                ( 6361 * acos( cos( radians('.Auth::user()->lat.') ) * cos( radians( lat ) ) * cos( radians( lon ) - radians('.Auth::user()->lon.') ) + sin( radians('.Auth::user()->lat.') ) * sin( radians( lat ) ) ) ) 
                                 AS distance'
                            )
                        )
                        ->having('distance', '<', 5)
                        ->orderBy('distance')
                        ->get();
        $liked_persons = [];
        $likeDatas = User_like::where('liked_person',Auth::id())->orWhere('user_id',Auth::id())->get();
        if($likeDatas){
            foreach ($likeDatas as  $likeData) {
                if($likeData->status == 0) array_push($liked_persons, $likeData->user_id);
                else {
                    array_push($liked_persons, $likeData->user_id);
                    array_push($liked_persons, $likeData->liked_person);
                }
            }
        }
        if (($key = array_search(Auth::id(), $liked_persons)) !== false) {
            unset($liked_persons[$key]);
        }
        if(!isset($_GET['page'])) $_GET['page'] = 1;
        $users = $result->forPage($_GET['page'], 10);
        $page_count = ceil(count($result)/10);
        $current_page = isset($_GET['page']) ? $_GET['page'] : 1;

        return view('list',compact('users','page_count','current_page','liked_persons'));
    }
}
