<?php

namespace App\Http\ViewComposers;
use App\User_like;
use Auth;
use Illuminate\Contracts\View\View;

class NotificationComposer {

	public function compose(View $view){
		$likedByObject  =   User_like::with(['user'])->where("liked_person",Auth::id())
	                            ->where("status",1)
	                            ->where('is_seen_by_user',0)
	                            ->orderBy('id','desc')
	                            ->first();
		$view->with('liked_by',$likedByObject);
	}
}

?>