<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
function err($msg=null){
    return ['status'=>0,'msg'=>$msg];
}
function succ($data_to_merge=[]){

    $data = ['status'=>1,'data'=>[]];
    if($data_to_merge)
        $data['data'] = array_merge($data['data'],$data_to_merge);
    return $data;
}

function paginate($page=1,$limit=16){
    $limit = $limit ?: 16;
    /*skip条件 用于分页 跳过几页*/
    $skip = ($page ? $page - 1 : 0)* $limit;
    return [$skip,$limit];
}

function user_ins(){
    return new \App\User;
}
function question_ins(){
	return new \App\Question;
};
function rq($key=null,$default=null){
	if(!$key)	return Request::all();
	return Request::get($key,$default);		
	
};
function answer_ins(){
  return new \App\Answer;
};
function comment_ins(){
    return new \App\Comment;
};

Route::get('/', function () {
    return view('index');
});
Route::any('api/signup',function (){
    return user_ins()->signup();
});
Route::any('api/login',function (){
    return user_ins()->login();
});
Route::any('api/logout',function (){
    return user_ins()->logout();
});
Route::any('api/user/change_password',function (){
    return user_ins()->change_password();
});
Route::any('api/user/reset_password',function (){
    return user_ins()->reset_password();
});
Route::any('api/user/validate_reset_password',function (){
    return user_ins()->validate_reset_password();
});
Route::any('api/user/read',function (){
    return user_ins()->read();
});
Route::any('api/user/exists',function (){
    return user_ins()->exists();
});

Route::any('api/question/add',function(){
	return question_ins()->add();
});
Route::any('api/question/change',function(){
	return question_ins()->change();
});
Route::any('api/question/read',function(){
    return question_ins()->read();
});

Route::any('api/question/remove',function(){
    return question_ins()->remove();
});

Route::any('api/answer/add',function(){
    return answer_ins()->add();
});
Route::any('api/answer/change',function(){
    return answer_ins()->change();
});
Route::any('api/answer/read',function(){
    return answer_ins()->read();
});
Route::any('api/answer/vote',function(){
    return answer_ins()->vote();
});
Route::any('api/comment/add',function(){
    return comment_ins()->add();
});
Route::any('api/comment/read',function(){
    return comment_ins()->read();
});
Route::any('api/comment/remove',function(){
    return comment_ins()->remove();
});
Route::any('api/timeline','CommonController@timeline');

Route::any('test',function (){
    dd(user_ins()->is_logged_in());
});