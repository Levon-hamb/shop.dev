<?php

class ForgotPass extends Eloquent
{
    protected $table = 'forgot_pass';
    public $timestamps = false;
    public static function setForgot($user_id, $hash){
        $forgot = ForgotPass::insert(array('user_id' => $user_id,'token' => $hash));
        return $forgot;
    }

    public static function deleteForgotPass($user_id){
        $user = ForgotPass::where(array('user_id' => $user_id))->delete();
        return $user;
    }

    public static function getUserId($token){
        $user_id = ForgotPass::where('token',$token)->first();
        return $user_id->user_id;
    }

}

?>