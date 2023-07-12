<?php

namespace App\Models;

use App\Traits\CustomCache;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    use HasRoles;
    use CustomCache;
    public $timestamps = true;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'active',
        'id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function get_current_user_name()
    {
        return User::find(\Auth::id())->name;
    }
    public static function get_current_id(){
    return User::find(\Auth::id())->id;
    }

    /**
     * Returns image of the passed in user id or default the logged in user id
     * @param null $user_id Pass in user id
     * @return string It will return image name [demo.jpg].
     */
    public static function get_user_photo($user_id = null)
    {

        if (!$user_id) {
            $user_id = \Auth::id();
        }
        $tmp = UserMeta::where("user_id", $user_id)->where("meta_key", "photo")->first();
        if ($tmp) {
            if (\File::exists(public_path("uploads/" . $tmp->meta_value))) { // Just to be on safer side
                return $tmp->meta_value;
            }
        }
        if (\File::exists(public_path("uploads/" . $user_id . ".jpg"))) {
            return $user_id . ".jpg";
        }
        $email = User::find($user_id)->email;
        $data = Str::of($email)->explode("@");
        if (count($data) == 2 && \File::exists(public_path("uploads/" . $data[0] . ".jpg"))) {
            return $data[0] . ".jpg";
        }
        $tmp = UserMeta::where("user_id", $user_id)->where("meta_key", "phone")->first();
        if ($tmp) {
            if (\File::exists(public_path("uploads/" . $tmp->meta_value . ".jpg"))) { // Just to be on safer side
                return $tmp->meta_value . ".jpg";
            }
        }
        return config("app.DEFAULT_USR_IMG");
    }

    /**
     * Returns image of the passed in user id or default the logged in user id
     * @param null $user_id Pass in user id
     * @return string It will return image name [demo.jpg].
     */
    public function get_user_image()
    {
        $tmp = UserMeta::where("user_id", $this->id)->where("meta_key", "photo")->first();
        if ($tmp) {
            if (\File::exists(public_path("uploads/" . $tmp->meta_value))) {
                // Just to be on safer side
                return $tmp->meta_value;
            }
        }
        if (\File::exists(public_path("uploads/" . $this->id . ".jpg"))) {
            return $this->id . ".jpg";
        }
        $data = Str::of($this->email)->explode("@");
        if (count($data) == 2 && \File::exists(public_path("uploads/" . $data[0] . ".jpg"))) {
            return $data[0] . ".jpg";
        }
        $tmp = UserMeta::where("user_id", $this->id)->where("meta_key", "phone")->first();
        if ($tmp) {
            if (\File::exists(public_path("uploads/" . $tmp->meta_value . ".jpg"))) { // Just to be on safer side
                return $tmp->meta_value . ".jpg";
            }
        }
        return config("app.DEFAULT_USR_IMG");
    }


    /**
     * Returns address of the passed in user id or default the logged in user id
     * @param null $user_id Pass in user id
     * @return string It will return user address | N/A.
     */
    public static function get_user_address($user_id = null)
    {
        if (!$user_id) {
            $user_id = \Auth::id();
        }
        $tmp = UserMeta::where("user_id", $user_id)->where("meta_key", "address")->first();
        if (!$tmp) {
            return "--";
        }
        return $tmp->meta_value;
    }

    /**
     * Returns phone number of the passed in user id or default the logged in user id
     * @param null $user_id Pass in user id
     * @return string It will return user phone number | N/A.
     */
    public static function get_phone_no($user_id = null)
    {
        if (!$user_id) {
            $user_id = \Auth::id();
        }
        $tmp = UserMeta::where("user_id", $user_id)->where("meta_key", "phone")->first();
        if (!$tmp) {
            return "--";
        }
        return $tmp->meta_value;
    }

    /**
     * Returns phone number of the default user id
     * @return string It will return user phone number | N/A.
     */
    public function get_phone()
    {

        $tmp = UserMeta::where("user_id", $this->id)->where("meta_key", "phone")->first();
        if (!$tmp) {
            return "--";
        }
        return $tmp->meta_value;
    }

    /**
     * Returns course & year details number of the default user id
     * @return string It will return user phone number | N/A.
     */
    public function get_academic_details()
    {

        $tmp = UserMeta::where("user_id", $this->id)->where("meta_key", "assigned_to")->first();
        if (!$tmp) {
            return "--";
        } else {
            $decodes = json_decode($tmp->meta_value, true);
            $course_name = '';
            $coure_year = '';
            foreach ($decodes as $decode) {
                foreach ($decode as $k => $v) {
                    try {
                        $course_name = \Common::getCourseName($k);
                        $coure_year = \Common::getCourseYearName($v);
                        break;
                    } catch (\Exception $e) {
                    }
                }
                break;
            }
            if (empty($course_name) && empty($coure_year)) {
                return "--";
            }
            return $course_name . ":" . $coure_year;
        }
        //return $tmp->meta_value;
    }

    /**
     * Returns user proof of the passed in user id or default the logged in user id
     * @param null $user_id Pass in user id
     * @return string It will return user phone number | N/A.
     */
    public static function get_specific_user_proof($user_id = null)
    {
        if (!$user_id) {
            $user_id = \Auth::id();
        }
        $tmp = UserMeta::where("user_id", $user_id)->where("meta_key", "proof")->first();
        if ($tmp && !empty($tmp->meta_value)) {
            if (\File::exists(public_path("uploads/" . $tmp->meta_value))) {
                return $tmp->meta_value;
            } else {
                return "";
            }
        }
        return "";
    }

    /**
     * Returns user name of the passed in user id or default the logged in user id
     * @param null $user_id Pass in user id
     * @return string It will return user name |  N/A.
     */
    public static function get_user_name($user_id = null)
    {
        if (!$user_id) {
            $user_id = \Auth::id();
        }else{

        }
        $tmp = User::where('id',$user_id)->first();
        if (!$tmp) {
            return "N/A";
        }

        return $tmp->name;
    }


    /**
     * Return current user roles
     * @return array
     */
    public static function get_current_user_roles_in_array()
    {

        if (User::find(Auth::id())->roles) {
            return User::find(Auth::id())->roles->pluck("pivot.role_id")->toArray();
        }
        return array();
    }

    /**
     * Returns current user roles.
     * @return mixed
     */
    public static function get_current_user_roles($v_id = null)
    {
    if(empty($v_id)){
     return User::find(Auth::id())->roles;

    }elseif($v_id == "check"){
     return User::find(Auth::id())->roles;
    }else{
    return User::find($v_id)->roles;
    }

    }

    public static function check_if_user_has_role($role_name)
    {
        foreach (self::get_current_user_roles() as $role) {
            if ($role->name == $role_name) {
                return true;
            }
        }
        return false;
    }

    public static function check_if_give_user_has_role($uid, $role_name)
    {
        $user_obj = User::find($uid);
        if ($user_obj) {
            foreach ($user_obj->roles as $role) {
                if ($role->name == $role_name) {
                    return true;
                }
            }
        }
        return false;
    }


    public static function check_if_user_has_access_to_this_std_div($cstd, $cdiv)
    {
        if (!UserMeta::where("user_id", Auth::id())->first()) {
            return false;
        }
        foreach (json_decode(UserMeta::where("user_id", Auth::id())->first()->get_assign()) as $items) {
            foreach ($items as $std => $div) {
                if ($cdiv == $div && $cstd == $std) {
                    return true;
                }
            }
        }
        return false;
    }

    public static function get_users_by_role($role_name)
    {
        return User::where("active", 1)->whereHas('roles', function ($q) use ($role_name) {
            $q->where('name', $role_name);
        });
    }

    /**
     * Setting a relationship
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function user_meta()
    {
        return $this->hasMany(UserMeta::class);
    }

    /** Returns User Object|Collections with metas for the given user id or the default logged in user id will be taken if left blank.
     * Dont make it a static function as the relation will also have to go along.
     * Which can mess up the system.
     * @param $property_name string Property name
     * @param int $user_id User Id
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function get_property($property_name, $user_id = 0)
    {
        if (Auth::check() && !$user_id) {
            $user_id = Auth::id();
        }
        $tmp = User::with(["user_meta" => function ($query) use ($property_name, $user_id) {
            $query->select("meta_value")->where("meta_key", $property_name)->where("user_id", $user_id)->first();
        }])->where("id", $user_id)->get();
        if ($tmp->count() == 1) {
            return $tmp->shift(); // Return single instance of user.
        } else {
            return $tmp; // Returns collections as more than 1 row was found.
        }
    }

    public function get_course($user_id)
    {
        if (!$user_id) {
            $user_id = \Auth::id();
        }
        $tmp = UserMeta::where("user_id", $user_id)->where("meta_key", "assigned_to")->first();
        if (!$tmp) {
            return "N/A";
        } else {
            try {
                $temp = json_decode($tmp->meta_value, true);
                $temp = $temp[0];
                $course = key($temp);
                $year = intval($temp[$course]);
            } catch (\Exception $e) {
                throw new \Exception("Received something unexpected. [UserModel:get_course]");
            }
        }
        return $course;
    }

    public function get_year($user_id)
    {
        if (!$user_id) {
            $user_id = \Auth::id();
        }
        $tmp = UserMeta::where("user_id", $user_id)->where("meta_key", "assigned_to")->first();
        if (!$tmp) {
            return "N/A";
        } else {
            try {
                $temp = json_decode($tmp->meta_value, true);
                $temp = $temp[0];
                $course = key($temp);
                $year = intval($temp[$course]);
            } catch (\Exception $e) {
                throw new \Exception("Received something unexpected. [UserModel:get_year]" .$e);
            }
        }
        return $year;
    }

    public function get_users_with_role($role_name)
    {
        return $this->whereHas('roles', function ($q) use ($role_name) {
            $q->where('name', $role_name);
        });
    }

    public function get_active()
    {
        return $this->where("active", 1);
    }

    public function get_in_active()
    {
        return $this->where("active", 0);
    }

    public function get_proof()
    {
        $tmp = UserMeta::where("meta_key", "proof")->where("user_id", $this->id)->first();
        if ($tmp) {
            if (\File::exists(public_path("uploads/" . $tmp->meta_value))) {
                return $tmp->meta_value;
            }
        }
        return "";
    }
}
