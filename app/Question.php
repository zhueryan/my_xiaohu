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
    /*更新问题api*/
    public function change(){
        /*检查用户是否登录*/
        if(!user_ins()->is_logged_in()){
            return ['status'=>0,'msg'=>'login required'];
        }

        /*检查传参中是否有id*/
        if(!rq('id'))
            return ['status'=>0,'msg'=>'id is required'];

        /*获取指定id的model*/
        $question = $this->find(rq('id'));
        if(!$question)
            return ['status'=>0,'msg'=>'question not exists'];
        /*判断问题是否存在*/
        if($question->user_id != session('user_id')){
            return ['status'=>0,'msg'=>'permission denied'];
        }

        if(rq('title'))
            $question->title = rq('title');

        if(rq('desc'))
            $question->desc = rq('desc');

        return $question->save() ?
            ['status'=>1] :
            ['status'=>0,'msg'=>'insert failed'];
    }
    /*查看问题api*/
    public function read(){
        /*请求参数中是否有id 有过有id直接返回id所在的行*/
        if(rq('id')){
            return ['status'=>1,'data'=>$this->find(rq('id'))];
        }
        /*limit 条件 每页多少条*/
//        $limit = rq('limit') ?: 15;
        /*skip条件 用于分页 跳过几页*/
//        $skip = (rq('page') ? rq('page')-1 : 0)* $limit;
        list($skip,$limit) = paginate(rq('page'),rq('limit'));
        /*构建query并返回collection数据*/
        $r =  $this->orderBy('created_at')
            ->limit($limit)
            ->skip($skip)
            ->get(['id','user_id','title','desc','created_at','updated_at'])
            ->keyBy('id');
        return ['status'=>1,'data'=>$r];
    }
    /*删除问题api*/
    public function remove(){
        /*检查用户是否登录*/
        if(!user_ins()->is_logged_in()){
            return ['status'=>0,'msg'=>'login required'];
        }
        /*检查传参中是否有id*/
        if(!rq('id')){
            return ['status'=>0,'msg'=>'id is required'];
        }
        /*获取传参id所对应的model*/
        $question = $this->find(rq('id'));
        if(!$question) return ['status'=>0,',msg'=>'question not exists'];
        /*检查当前用户是否为问题所有者*/
        if(session('user_id') != $question->user_id)
            return ['status'=>0,',msg'=>'permission denied'];
        /*删除问题*/
        return $question->delete() ?
            ['status'=>1] :
            ['status'=>0,'msg'=>'db delete failed'];
    }
}
