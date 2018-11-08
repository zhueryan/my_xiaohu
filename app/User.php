<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Hash;
use Request;  //laravel 5.2版本后 使用Request::get() 要这样使用 注释掉默认的Request包含

class User extends Model
{
    /**
     * 注册API
     * @return array|int
     */
    public function signup(){
        $has_username_and_password = $this->has_username_and_password();
        /*检查用户名和密码是否为空*/
        if(!$has_username_and_password){
            return err('用户名和密码不可为空');
        }
        $username = $has_username_and_password[0];
        $password = $has_username_and_password[1];
        /*检查用户是否已经存在*/
        $user_exists = $this->where('username',$username)->exists();
        if($user_exists){
            return err('用户名已存在');
        }
        /*加密密码*/
//        $hashed_password = Hash::make($password);
        $hashed_password = bcrypt($password);
        /*存入数据库*/
        $user = $this;
        $user->password = $hashed_password;
        $user->username = $username;
        if($user->save())
            return succ(['id'=>$user->id]);
        else
            return ['status'=>0,'id'=>'DB INSERT FAILED'];

        return 1;
    }
    /**
     * 登陆API
     */
    public function login(){
        /*检查用户名和密码是否存在*/
        $has_username_and_password = $this->has_username_and_password();
        /*检查用户名和密码是否为空*/
        if(!$has_username_and_password){
            return err('username and password are required');
        }
        $username = $has_username_and_password[0];
        $password = $has_username_and_password[1];
        /*检查用户是否存在*/
        $user = $this->where('username',$username)->first();
        if(!$user){
            return err('user not exists！');
        }
        /*检查密码是否正确*/
        $hashed_password = $user->password;
        if(!Hash::check($password,$hashed_password)){
            return err('invalid password！');
        }
        /*将用户信息写入session*/
        session()->put('username',$username);
        session()->put('user_id',$user->id);
        return succ(['id'=>$user->id]);
    }
    public function has_username_and_password(){
        $username = Request::get('username');
        $password = Request::get('password');
        /*检查用户名和密码是否为空*/
        if($username && $password)
            return [$username,$password];
        else
            return false;
    }
    /*登出API*/
    public function logout(){
        /*删除用户信息*/
        session()->forget('username');
        session()->forget('user_id');
        return succ();
    }
    /**
     * 检测用户是否已经登陆
     */
    public function is_logged_in(){
        /*如果session中存在user_id就返回user_id,否则返回false*/
        return session('user_id') ?: false;
    }


    /*与answer建立多对多的关系*/
    public function answers(){
        return $this
            ->belongsToMany('App\Answer')
            ->withPivot('vote')
            ->withTimestamps();
    }
    /*修改密码api*/
    public function change_password(){
        if(!user_ins()->is_logged_in())
            return err('login is required');

        if(!rq('old_password') || !rq('new_password'))
            return err('old_password and new_password are required');

        $user  = $this->find(session('user_id'));

        if(!Hash::check(rq('old_password'),$user->password))
            return err('invalid old_password');

        $user->password = bcrypt(rq('new_password'));
        return $user->save() ?
            succ() :
            err('db update failed');
    }
    /*验证找回密码api*/
    public function validate_reset_password()
    {
        if($this->is_robot(2))
            return err('max frequency reached');

        if(!rq('phone') || !rq('phone_captcha') || !rq('new_password'))
            return err('phone and phone_captcha are required');
        /*检查用户是否存在*/
        $user = $this->where('phone',rq('phone'))
            ->where('phone_captcha',rq('phone_captcha'))
            ->first();
        if(!$user)
            return err('invalid phone or phone_captcha');
        /*加密新密码*/
        $user->password = bcrypt(rq('new_password'));
        $this->update_robot_time();
        return $user->save() ?
                succ() : err('db update failed');


    }

    /*找回密码api*/
    public function reset_password()
    {

        if($this->is_robot())
            return err('max frequency reached');

        if(!rq('phone'))
            return err('phone is required');

        $user = $this->where('phone',rq('phone'))->first();

        if(!$user)
            return err('invalid phone number');
        /*生成验证码*/
        $captcha = $this->generate_captcha();
        $user->phone_captcha = $captcha;
        if($user->save()){
            /*如果验证码保存成功，发送验证码短信*/
            $this->send_sms();
            /*为下一次调用短信接口作准备*/
            $this->update_robot_time();
            return succ();
        }
        return err('db update failed');

    }
    /*检查机器人*/
    public function is_robot($time = 10){
        /*如果session中没有last_active_time 说明接口从未被调用过*/
        if(!session('last_active_time'))
            return false;
        $current_time = time();
        $last_active_time = session('last_active_time');
        return !($current_time - $last_active_time > $time);

    }
    /*更新机器人行为时间*/
    public function update_robot_time(){
        session()->set ('last_active_time',time());
    }

    /*发送短信*/
    public function send_sms(){
        return true;
    }
    /*生成验证码*/
    public function generate_captcha()
    {
        return rand(1000,9999);
    }
}
