<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	protected $table = 'users';

	protected $hidden = array('password', 'remember_token');

	public static function getUserIdByEmail($email){
		$user_id = User::select('id')->where('email', $email)->get();
		return $user_id[0]->id;
	}


	public static function uniqueEmail($email){

		$user = User::where('email', $email)->first();
		return $user;
	}


	public static function signUp($date){

		$data_time = new \DateTime;
		$user = User::insert(
			array('email' => $date['email'],
				'user_name' => $date['user_name'],
				'password' =>	Hash::make($date['password']),
				'phone_number' =>$date['phone_number'],
				'created_at' => $data_time,
				'updated_at' => $data_time
		));
		return $user;
	}

	public static function save_pass($date){

		if(Auth::check()) {
			$pass = User::where('id', Auth::user()->id)
				->update(array('password' => Hash::make($date['new_password'])));
			return $pass;
		}else{

			$pass = User::where('id', $date['id'])
				->update(array('password' => Hash::make($date['new_password'])));
			$delete = ForgotPass::where('user_id', $date['id'])->delete();
			return $pass;
		}
	}

	public static function saveProfile($date){
		$profile = User::where('id', Auth::user()->id)
			->update(array('phone_number' => $date['phone_number'], 'user_name' => $date['user_name']));
		return $profile;
	}

	public function products() {
		return $this->hasMany('Product');
	}

}
