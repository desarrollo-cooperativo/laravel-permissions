<?php

namespace Cardumen\LaravelPermissions\Traits;
use DB;
use Cardumen\LaravelPermissions\Models\Role;
trait UserRole {
	
	public function is_root(){
		return $this->roles()->where('is_root','=',true)->count() > 0;
	}



	public function roles(){
		return $this->belongsToMany(App\Role::class);
	}

	private function permissions(){
		$role = $this->getActiveRole();
		$permissions = $role->permissions();
		return $permissions;

	}

	public function routeAllowed($routename){
		return ($this->is_root()) ? true : ($this->permissions()->where('permissions.route','=',$routename)->count() > 0);
	}
	
	public function permissionAllowed($name){
		return ($this->is_root()) ? true : ($this->permissions()->where('permissions.permission','=',$name)->count() > 0);
	}

	public function setActiveRole($role_id){
		//check if user has role
		if(!$this->hasRoleId($role_id)){
			abort(401,'Acción no autorizada');
		}
		//set active role in session
		session(['role_id' => $role_id]);
	}

	public function getActiveRole(){
		$role_id = session('role_id',$this->roles()->first()->id);
		//check if user has role
		if(!$this->hasRoleId($role_id)){
			abort(401,'Acción no autorizada');
		}
		
		return Role::where('id','=',$role_id)->first();

	}

	private function hasRoleId($role_id){
		return ($this->roles()->where('roles.id','=',$role_id)->count() > 0);
	}
}