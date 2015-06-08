<?php

class UserController extends BaseController {

    public function signIn()
    {
        $data = Input::all();
        $rules = array(
            'password' => 'required|min:6|regex:/^([a-z0-9_-]{6,18}$)/i',
            'email' => 'required|email'
        );
        $validator = Validator::make($data, $rules);

        if( $validator->fails() ) {
            $messages = $validator->messages()->all();
            return View::make('user/signIn')->with('errors', $messages)->with('old_data', $data);
        }
        else {
            if(!isset($data['remember'])){
                $data['remember'] = false;
            }
            if($user = Auth::attempt(array('email' => $data['email'], 'password' => $data['password']), $data['remember'])){
                if(Request::ajax()){
                    if ($user){
                        echo '1';

                    }else{
                        echo '0';
                    }
                }elseif($user){
                    return Redirect::to('/');
                }else{
                    $messages = 'this user does not exist';
                    return View::make('user/signIn')->with('not_exist', $messages)->with('old_data', $data);
                }
            }

        }


    }

    public function signUp(){
        $data = Input::all();
        $rules = array(
            'user_name' => 'required',
            'password' => 'required|min:6|regex:/^([a-z0-9_-]{6,18}$)/i',
            're_password' => 'required|min:6|same:password|regex:/^([a-z0-9_-]{6,18}$)/i',
            'email' => 'required|email|unique:users',
            'phone_number' => 'required|min:9|regex:/^([0-9-]{9,18}$)/i'
        );
        $validator = Validator::make($data, $rules);

        if($validator->fails()){
            $messages = $validator->messages()->all();
            return View::make('user/signUp')->with('errors', $messages)->with('old_data', $data);
        }else {
            $user = User::signUp($data);
            if($user){
                if ($user = Auth::attempt(array('email' => $data['email'], 'password' => $data['password']))) {
                    if(Request::ajax()) {
                        if ($user) {
                            echo "1";
                        } else {
                            echo '0';
                        }
                    }elseif($user){
                        return Redirect::to('/');
                    }else{
                        $messages = 'error sign up';
                        return View::make('user/signUp')->with('not_exist', $messages)->with('old_data', $data);
                    }
                }else{
                    return Redirect::to('/');
                }
            }
        }
    }

    public function uniqueEmail(){

        $email = Input::get('email');
        $user = User::uniqueEmail($email);

        if($user != null){
            echo 1;
        }else{
            echo 0;
        }

    }

    public function logout(){
        $user = Auth::logout();
        return Redirect::to('/');
    }

    public function profile(){
        $user = Auth::user();

//        dd(Auth::user()->is_admin);
        return View::make('user/profile')->with('user',$user);

    }

    public function save_pass(){
        $date = Input::all();

        $rules = array(
            'new_password' => 'required|min:6|regex:/^([a-z0-9_-]{6,18}$)/i',
            'new_confirm_pass' => 'required|min:6|same:new_password|regex:/^([a-z0-9_-]{6,18}$)/i',
        );
        $validator = Validator::make($date, $rules);

        if( $validator->fails() ) {
            $messages = $validator->messages()->all();
            return View::make('user/resetPassword')->with('errors', $messages);
        }
        else {

            $pass = User::save_pass($date);
            if(Request::ajax()) {
                if ($pass) {
                    echo "1";
                } else {
                    echo "0";
                }
            }else{
                return Redirect::to('profile');
            }
        }
    }

    public function saveProfile(){
        $date = Input::all();

        $rules = array(
            'phone_number' => 'required|min:8|regex:/^([0-9]{8,18}$)/i',
            'user_name' => 'required|min:2|regex:/^([a-z0-9_-]{2,18}$)/i',
        );
        $validator = Validator::make($date, $rules);

        if( $validator->fails() ) {

            $messages = $validator->messages()->all();
            return View::make('user/editProfile')->with('errors', $messages)->with('old_date', $date);
        }else{
            $profile = User::saveProfile($date);

            if(Request::ajax()){
                if($profile){
                    echo '1';
                }else{
                    echo '0';
                }
            }elseif($profile){
                return Redirect::to('profile');
            }
        }


    }

    public function edit_profile(){
        $user = Auth::user();
        return View::make('user/editProfile')->with('user',$user);
    }

    public function resetpassword(){
        return View::make('user/resetPassword');

    }

    public function getProducts(){
        $user = new User();
        $products = $user->find(Auth::user()->id)->products;
        return View::make('user/product')->with('products', $products);

    }

}
