<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use App\persons;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\internalaccounts;
use DB;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {

        $data_ctl_users=array(
            'username'=>$data['name'],
            'password'=>Hash::make($data['password']),
            'salt'=>'this is a test salt',
            'status'=>1,
            'appKey'=>'test appkey',
            'code'=>'burned code',
            'rankingStatus'=>'1',
            'state_id'=>1,
            'ranking_id'=>1,
            'registerType_id'=>1,
            'historyStatus'=>1
        );

        $last_id = DB::table('ctl_users')->insertGetId($data_ctl_users);

        internalaccounts::create([
            'code'=>1,
            'balance'=>0,
            'status'=>1,
            'ctl_user_id'=>$last_id
        ]);

        persons::create([
            'firstName'=>$data['name'],
            'lastName'=>$data['name'],
            'email'=>$data['email'],
            'birthDate'=>'2002-01-30',
            'photography'=>'123456789',
            'ctl_user_id'=>$last_id
        ]);
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password'])
        ]);
    }
}
