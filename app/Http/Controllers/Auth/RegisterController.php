<?php

namespace App\Http\Controllers\Auth;

use \App\Facades\Common;
use App\Helper\Util;
use App\Http\Controllers\Controller;
use App\Models\UserMeta;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

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
    protected $redirectTo = '/login';

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
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $to_validate = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'phone' => ['required', 'string', 'min:8'],
        ];
        if(isset($data["photo"])){
            $to_validate[]=["photo"=>"max:1024|mimes:jpg,jpeg,png"];
        }
        if(isset($data["proof"])){
            $to_validate[]=["proof"=>"max:2048|mimes:jpg,jpeg,png,pdf"];
        }
        return Validator::make($data, $to_validate);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $user_obj = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
        if ($user_obj) {
            User::find($user_obj->id)->assignRole(Role::findById(Common::getDafaultRole())->name);
            if (isset($data["phone"])) {
                UserMeta::updateOrCreate(["meta_key" => "phone", "meta_value" => $data["phone"], "user_id" => $user_obj->id]);
            }
            if (isset($data["photo"])) {
                $photo = \App\Facades\Util::uploadFile($data["photo"]);
                UserMeta::updateOrCreate(["meta_key" => "photo", "meta_value" => $photo, "user_id" => $user_obj->id]);
            }
            if (isset($data["proof"])) {
                $proof = \App\Facades\Util::uploadFile($data["proof"]);
                UserMeta::updateOrCreate(["meta_key" => "proof", "meta_value" => $proof, "user_id" => $user_obj->id]);
            }
            if (isset($data["sel_course"]) && isset($data["sel_year"])) {
                UserMeta::updateOrCreate(["meta_key" => "assigned_to", "meta_value" => json_encode([array($data["sel_course"] => $data["sel_year"])]),
                    "user_id" => $user_obj->id]);
            }
        }
        return $user_obj;
    }

    /**
     * The user has been registered.
     *
     * @param \Illuminate\Http\Request $request
     * @param mixed $user
     * @return mixed
     */
    protected function registered(Request $request, $user)
    {
        //
        Auth::logout();
        Session::flush();
        \Session::flash("login_form", true);
        \Session::flash("alert-success", __("common.you_have_been_signed_up_now_waiting_for_approval"));
        return redirect('/login');
    }
}
