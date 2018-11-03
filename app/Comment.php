<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    /*添加评论api*/
    public function add(){
        if(!user_ins()->is_logged_in())
            return ['status'=>0,'msg'=>'login required'];

        if(!rq('content'))
            return ['status'=>0,'msg'=>'empty  content'];

        /*检查是否存在question_id或answer_id*/
        if((!rq('question_id') && !rq('answer_id')) ||
            (rq('question_id') && rq('answer_id')))
            return ['status'=>0,'msg'=>'question_id or answer_id is required'];

        if(rq('question_id')){
            /*评论问题*/
            $question = question_ins()->find(rq('question_id'));
            /*检查问题是否存在*/
            if(!$question) return ['status'=>0,'msg'=>'question not exists'];
            $this->question_id = rq('question_id');

        }else{
            /*评论答案*/
            $answer = answer_ins()->find(rq('answer_id'));
            /*检查答案是否存在*/
            if(!$answer) return ['status'=>0,'msg'=>'answer not exists'];
            $this->answer_id = rq('answer_id');
        }
        /*检查是否在回复评论*/
        if(rq('replay_to'))
        {
            $target = comment_ins()->find(rq('replay_to'));
            /*检查目标评论是否存在*/
            if(!$target) return ['status'=>0,'msg'=>'target comment not exists'];
            /*检查是否在回复自己的评论 */
            if($target->user_id == session('user_id'))
                return ['status'=>0,'msg'=>'cannot replay to your self'];
            $this->replay_to = rq('replay_to');
        }

        $this->content = rq('content');
        $this->user_id = session('user_id');

        return $this->save() ?
            ['status'=>1,'id'=>$this->id] :
            ['status'=>0,'msg'=>'db insert failed'];

    }

    /*查看评论api*/
    public function read(){

        if(!rq('question_id') && !rq('answer_id'))
            return ['status'=>0,'msg'=>'question_id or answer_id is required'];

        if(rq('question_id'))
        {
            $question = question_ins()->find(rq('question_id'));
            if(!$question) return ['status'=>0,'msg'=>'question not exists'];
            $data = $this->where('question_id',rq('question_id'));
        }else{
            $answer = answer_ins()->find(rq('answer_id'));
            if(!$answer) return ['status'=>0,'msg'=>'answer not exists'];
            $data = $this->where('answer_id',rq('answer_id'));
        }
        $data = $data->get()->keyBy('id');
        return ['status'=>1,'data'=>$data];
    }

    /*删除评论api*/
    public function remove(){

        if(!user_ins()->is_logged_in())
            return ['status'=>0,'msg'=>'login is required'];

        if(!rq('id'))
            return ['status'=>0,'msg'=>'id is required'];

        $comment = $this->find(rq('id'));
        if(!$comment)
            return ['status'=>0,'msg'=>'comment not exists'];

        if($comment->user_id != session('user_id'))
            return ['status'=>0,'msg'=>'permission denied'];
        /*先删除此评论下所有的评论*/
        $this->where('replay_to',rq('id'))->delete();

        return $comment->delete() ?
            ['status'=>1]:
            ['status'=>0,'msg'=>'db delete failed'];
    }
}
