<?php

require_once  app_path() . "/config/constants.php";
class IndexController extends BaseController {

    public function index()
    {
        $products = Product::all();
        return View::make('index')->with('products', $products);
    }

    public function signUp(){

        return View::make('user/signUp');
    }

    public function signIn(){

        return View::make('user/signIn');
    }

    public function forgot(){
        return View::make('forgotpass');
    }

    public function forgotPass()
    {
        $date = Input::all();
        $rules = array(
            'email' => 'required|email|NotUnique:users',
        );
        $messag = array('email.not_unique' => 'user not exist');
        $validator = Validator::make($date, $rules, $messag);

        if ($validator->fails()) {

            $messages = $validator->messages()->all();
            return View::make('forgotpass')->with('errors', $messages)->with('old_date', $date['email']);
        } else {

            if ($date['email']) {
                $user_id = User::getUserIdByEmail($date['email']);

                $rand = rand(11111, 9999999999);
                $link = SITE_URL . '/resetpass/' . $rand;

                $forgot_pass_delete = ForgotPass::deleteForgotPass($user_id);
                $forgot_pass = ForgotPass::setForgot($user_id, $rand);

//        $content = $link;
//        $mail = mail($date['email'], 'Reset Password', $content);

                if(Request::ajax()){
                    echo $link;
                }else{
                    dd($link);
                    $message = "Email send successful" . $link;
                    return View::make('index')->with('message', $message);
                }
            } else {
                return Redirect::to('/');
            }
        }
    }

    public function reset($token){
        $user_id = ForgotPass::getUserId($token);
        $delete_token = ForgotPass::deleteForgotPass($user_id);
        return View::make('user/resetPassword')->with('id',$user_id);
    }

}
