<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
	/*创建问题*/
    public function add(){
    	/*检查用户是否登录*/
    	if(!user_ins()->is_logged_in()){
    		return ['status'=>1,'msg'=>'login required'];
    	}
    	/*检查是否存在标题*/
    	if(!rq('title')) 
    		return ['status'=>0,'msg'=>'required title'];
    	$this->title = rq('title');
    	$this->user_id = session('user_id');
    	if(rq('desc')) //如果存在描述就添加描述
    		$this->desc = rq('desc');
    	/*保存*/
    	return $this->save() ? 
    	['status'=>1,'id'=>$this->id] : 
    	['status'=>0,'msg'=>'insert failed'];
    	
    }
    
}
