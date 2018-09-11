<?php

namespace App\Http\Controllers;

use App\User_like;
use Auth;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function notification_seen(Request $request){
        $likedByObject                      =   User_like::where("liked_person",Auth::id())
                                                            ->where("status",1)
                                                            ->where("is_seen_by_user",0)
                                                            ->first();
        if($likedByObject) {
            $likedByObject->is_seen_by_user            =   1;
            $likedByObject->save();
            if($likedByObject->id) return response()->json(['success'=>'Operation Successful']);
            else return response()->json(['error'=>'Operation Unsuccessful']);
        } else {
            return response()->json(['error'=>'Operation Unsuccessful !']);
        }
    }
}
