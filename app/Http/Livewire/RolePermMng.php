<?php

namespace App\Http\Livewire;

use App\Facades\Common;
use App\Facades\Util;
use App\Models\User;
use App\Models\UserNotif;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Component;
use Spatie\Permission\Exceptions\PermissionAlreadyExists;
use Spatie\Permission\Exceptions\RoleAlreadyExists;
use Spatie\Permission\Exceptions\RoleDoesNotExist;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermMng extends Component
{
    public $roles;
    public $permissions;
    public $users;
    public $role_name;
    public $permission_name;
    public $role_id;
    public $permission_id;
    public $role_mode = "create";
    public $permission_mode = "create";
    public $assigned_role_id;
    public $user_id;
    protected $listeners = ["deleteRole", "deletePermission", "detachPermissionFromRole", "detachUserFromRole"];

    public function mount()
    {
        $this->roles = Common::getAllRoles();
        $this->permissions = Common::getAllPermissions();
        $this->users = Common::getAllUsers();
    }

    public function render()
    {
        return view('livewire.role-perm-mng');
    }

    public function saveRole()
    {
        session()->flash("form_permission", true);
        if ($this->role_name == "") {
            $this->dispatchBrowserEvent("show_message", ["type" => "warning", "title" =>
                __("common.notice"), "message" => __("common.role_name_cannot_be_left_empty")]);
            return;
        }
        try {
            try {
                Role::findByName("super admin");
            } catch (RoleDoesNotExist $ex) {
                Role::findOrCreate(Str::lower("super admin"));
            }
            if ($this->role_mode == "create") {
                Role::findOrCreate(Str::lower($this->role_name));
            } else {
                DB::table("roles")->where("id", $this->role_id)->update(['name' => Str::lower($this->role_name)]);
                app()->make(PermissionRegistrar::class)->forgetCachedPermissions();
            }
            $this->roles = Role::all();
            $this->role_name = "";
            session()->flash("alert-success", __("common.role") . " " . __($this->role_mode == "edit" ? "common.updated" : "common.created") . ".");
        } catch (RoleAlreadyExists $ex) {
            session()->flash("alert-danger", __("common.role_already_exist"));
        }
    }

    public function editRoleName($id)
    {
        $this->role_mode = "edit";
        $this->role_name = Role::findById($id)->name;
    }

    public function editPermissionName($id)
    {
        $this->permission_mode = "edit";
        $this->permission_name = Permission::findById($id)->name;
    }

    public function assignPermissionToRole()
    {
        session()->flash("form_permission", true);
        if (!empty($this->role_id) && !empty($this->permission_id)) {
            Role::findById($this->role_id)->givePermissionTo(Permission::findById($this->permission_id)->name);
            session()->flash("alert-success", __("common.perm_ass_to_role"));
        }
    }

    public function savePermission()
    {
        session()->flash("form_permission", true);
        if ($this->permission_name == "") {
            $this->dispatchBrowserEvent("show_message", ["type" => "warning", "title" =>
                __("common.notice"), "message" => __("common.perm_name_cannot_be_left_empty")]);
            return;
        }
        try {
            if ($this->permission_mode == "create") {
                Permission::findOrCreate(\App\Facades\Common::utf8Slug(Str::lower($this->permission_name)));
            } else {
                DB::table("permissions")->where("id", $this->permission_id)->update(['name' => Str::lower($this->permission_name)]);
                app()->make(PermissionRegistrar::class)->forgetCachedPermissions();
            }
            # This will make sure that we always assign all the role to the super admin user.
            Role::findOrCreate("super admin")->givePermissionTo(\App\Facades\Common::utf8Slug(Str::lower($this->permission_name)));
            $this->permissions = Permission::all();
            $this->permission_name = "";
            session()->flash("alert-success", __("common.permission") . " " .
                __($this->permission_mode == "edit" ? "common.updated" : "common.created") . ".");
        } catch (PermissionAlreadyExists $ex) {
            session()->flash("alert-success", __("common.perm_already_exist"));
        }
    }

    public function deleteRole($datas)
    {
        session()->flash("form_permission", true);
        $datas = Util::getCleanedLiveArray($datas);
        $id = isset($datas["id"]) ? $datas["id"] : 0;
        if ($id) {
            $tmp = Role::findById($id);
            if ($tmp) {
                $tmp->delete();
            }
            $this->roles = Role::all();
            $this->role_id = "";
            session()->flash("alert-success", __("common.role_del"));
        } else {
            session()->flash("alert-danger", __("common.id_missing"));
        }
    }

    public function deletePermission($datas)
    {
        session()->flash("form_permission", true);
        $datas = Util::getCleanedLiveArray($datas);
        $id = isset($datas["id"]) ? $datas["id"] : 0;
        if ($id) {
            $tmp = Permission::findById($id);
            if ($tmp) {
                $tmp->delete();
            }
            $this->permissions = Permission::all();
            $this->permission_id = "";
            session()->flash("alert-success", __("common.perm_del"));
        } else {
            session()->flash("alert-danger", __("common.id_missing"));
        }
    }

    public function detachPermissionFromRole($datas)
    {
        $datas = Util::getCleanedLiveArray($datas);
        $perm_id = isset($datas["id"]) ? $datas["id"] : 0;
        $role_id = isset($datas["role_id"]) ? $datas["role_id"] : 0;
        session()->flash("form_permission", true);
        if (!empty($role_id) && !empty($perm_id)) {
            Role::findById($role_id)->revokePermissionTo(Permission::findById($perm_id)->name);
            session()->flash("alert-success", __("common.perm_rvk_role"));
        }
    }

    public function detachUserFromRole($datas)
    {
        $datas = Util::getCleanedLiveArray($datas);
        $user_id = isset($datas["id"]) ? $datas["id"] : 0;
        $role_id = isset($datas["role_id"]) ? $datas["role_id"] : 0;
        session()->flash("form_permission", true);
        if (!empty($role_id) && !empty($user_id)) {
            User::find($user_id)->removeRole(Role::findById($role_id)->name);
             $notifinfo = [];
                        array_push($notifinfo, array( "User"  => $user_id,"Action" => "is no longer part of" ,"Target" => Role::findById($role_id)->name,"Modifier" => ""));
                        UserNotif::updateOrCreate(["user_id" => \Auth::Id(),"meta_value" => json_encode($notifinfo),"meta_key" => "Demotion","isread" => 0]);
            session()->flash("alert-success", __("common.role_rvk_usr"));
        }
    }

    public function attachRoleToUser()
    {
        session()->flash("form_permission", true);
        if (!empty($this->user_id) && !empty($this->assigned_role_id)) {
            User::find($this->user_id)->assignRole(Role::findById($this->assigned_role_id)->name);
             $notifinfo = [];
                        array_push($notifinfo, array( "User"  => $this->user_id,"Action" => "Promoted to" ,"Target" => $this->assigned_role_id,"Modifier" => ""));
                        UserNotif::updateOrCreate(["user_id" => \Auth::Id(),"meta_value" => json_encode($notifinfo),"meta_key" => "Promotion","isread" => 0]);
            session()->flash("alert-success", __("common.role_ass_usr"));
        }
    }
}
