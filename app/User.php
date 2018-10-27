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
            return ['status'=>0,'msg'=>'用户名和密码不可为空'];
        }
        $username = $has_username_and_password[0];
        $password = $has_username_and_password[1];
        /*检查用户是否已经存在*/
        $user_exists = $this->where('username',$username)->exists();
        if($user_exists){
            return ['status'=>0,'msg'=>'用户名已存在'];
        }
        /*加密密码*/
//        $hashed_password = Hash::make($password);
        $hashed_password = bcrypt($password);
        /*存入数据库*/
        $user = $this;
        $user->password = $hashed_password;
        $user->username = $username;
        if($user->save())
            return ['status'=>1,'id'=>$user->id];
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
            return ['status'=>0,'msg'=>'用户名和密码不可为空'];
        }
        $username = $has_username_and_password[0];
        $password = $has_username_and_password[1];
        /*检查用户是否存在*/
        $user = $this->where('username',$username)->first();
        if(!$user){
            return ['status'=>0,'msg'=>'用户不存在！'];
        }
        /*检查密码是否正确*/
        $hashed_password = $user->password;
        if(!Hash::check($password,$hashed_password)){
            return ['status'=>0,'msg'=>'密码错误！'];
        }
        /*将用户信息写入session*/
        session()->put('username',$username);
        session()->put('user_id',$user->id);
        return ['status'=>1,'id'=>$user->id];
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
        return ['status'=>1];
    }
    /**
     * 检测用户是否已经登陆
     */
    public function is_logged_in(){
        /*如果session中存在user_id就返回user_id,否则返回false*/
        return session('user_id') ?: false;
    }
}
