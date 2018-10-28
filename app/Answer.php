<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    /*添加回答api*/
    public function add(){
        /*检查用户是否登录*/
        if(!user_ins()->is_logged_in())
            return ['status'=>0,'msg'=>'login required'];
        /*检查参数中是否存在question_id和content*/
        if(!rq('question_id') || !rq('content'))
            return ['status'=>0,'msg'=>'question_id and content are required'];
        /*检查问题是否存在*/
        $question = question_ins()->find(rq('question_id'));
        if(!$question)
            return ['status'=>0,'msg'=>'question not exists'];
        /* 检查是否重复回答 */
        $answerd =$this->where(['user_id'=>rq('user_id'),'question_id'=>rq('question_id')]);
        if($answerd)
            return ['status'=>0,'msg'=>'duplicate answers'];
        /*保存数据*/
        $this->user_id = session('user_id');
        $this->question_id = rq('question_id');
        $this->content = rq('content');

        return $this->save() ?
            ['status'=>1,'id'=>$this->id]:
            ['status'=>0,'msg'=>'db insert failed'];

    }
}
