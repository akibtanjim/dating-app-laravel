<?php

namespace App\Http\Controllers;
use App\User_like;
use Auth;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function user_like(Request $request){

        $likedObject                        =   User_like::where("liked_person",Auth::id())
                                                ->where("user_id",$request->user_id)
                                                ->first();
        if($likedObject) {
            if($request->type === 'like') {
                $likedObject->status            =   1;
                $likedObject->save();
                if($likedObject->id) return response()->json(['success'=>'Like/Unlike operation Successful !']);
                else return response()->json(['error'=>'Like/Unlike operation Unsuccessful !']);
            } else {
                if($likedObject->delete()) return response()->json(['success'=>'Like/Unlike operation Successful !']);
                else return response()->json(['error'=>'Like/Unlike operation Unsuccessful !']);
            }  
        } else {
            $likedByObject                      =   User_like::where("user_id",Auth::id())
                                                                ->where("liked_person",$request->user_id)
                                                                ->first();
            if($likedByObject) {
                if($request->type === 'like') {
                    $likedByObject->status            =   1;
                    $likedByObject->save();
                    if($likedByObject->id) return response()->json(['success'=>'Like/Unlike operation Successful !']);
                    else return response()->json(['error'=>'Like/Unlike operation Unsuccessful !']);
                } else {
                    if($likedByObject->delete()) return response()->json(['success'=>'Like/Unlike operation Successful !']);
                    else return response()->json(['error'=>'Like/Unlike operation Unsuccessful !']);
                }  
            } else {
                $like                           =   new User_like;
                $like->user_id                  =   $request->user_id;
                $like->liked_person             =   Auth::id();
                //$like->status                   =   $request->value;
                $like->created_at               =   date('Y-m-d H:i:s',time());
                $like->save();
                if($like->id) return response()->json(['success'=>'Like/Unlike operation Successful !']);
                else return response()->json(['error'=>'Like/Unlike operation Unsuccessful !']);
            } 
        }
    }
}
