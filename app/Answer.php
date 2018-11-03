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
        $answerd =$this->where(['user_id'=>session('user_id'),'question_id'=>rq('question_id')])->exists();
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
    /*更新回答api*/
    public function change(){
        /*检查用户是否登录*/
        if(!user_ins()->is_logged_in())
            return ['status'=>0,'msg'=>'login required'];

        if(!rq('id') || ! rq('content'))
            return ['status'=>0,'msg'=>'id and content are required'];

        $answer = $this->find(rq('id'));
        if($answer->user_id != session('user_id'))
            return ['status'=>0,'msg'=>'permission denied'];

        $answer->content = rq('content');
        return $answer->save() ?
            ['status'=>1] :
            ['status'=>0,'msg'=>'db update failed'];
    }
    /*查看回答api*/
    public function read(){
        if(!rq('id') && !rq('question_id'))
            return ['status'=>0,'msg'=>'id or question_id is required'];
        /*单个回答查看*/
        if(rq('id')){
            $answer = $this->find(rq('id'));
            if(!$answer)
                return ['status'=>0,'msg'=>'answer not exists'];
            return ['status'=>1,'data'=>$answer];
        }
        /*在查看回答前 检查问题是否存在*/
        if(!question_ins()->find(rq('question_id')))
            return ['status'=>0,'msg'=>'question not exists'];
        /*查看同一问题的所有回答*/
        $answers = $this->where('question_id',rq('question_id'))
            ->get()
            ->keyBy('id');
        return ['status'=>1,'data'=>$answers];
    }
    /*投票api*/
    public function vote(){
        if(!user_ins()->is_logged_in())
            return ['status'=>0,'msg'=>'login required'];

        if(!rq('id') || !rq('vote'))
            return ['status'=>0,'msg'=>'id and vote are required'];

        $answer = $this->find(rq('id'));
        if(!$answer) return ['status'=>0,'msg'=>'answer not exists'];
        $vote = rq('vote') <= 1 ? 1 : 2;
        /*检查此用户是否在相同问题下投过票 如果投过票就删除投票*/
        $vote_ins = $answer->users()
            ->newPivotStatement()
            ->where('user_id',session('user_id'))
            ->where('answer_id',rq('id'))
            ->delete();
        /*在连接表中增加数据*/
        $answer->users()->attach(session('user_id'),['vote'=>$vote]);

        return ['status'=>1];
    }

    /*与user建立多对多的关系*/
    public function users(){
        return $this
            ->belongsToMany('App\User')
            ->withPivot('vote')
            ->withTimestamps();
    }
}
