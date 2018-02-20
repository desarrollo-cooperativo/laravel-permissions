<?php

namespace Cardumen\LaravelPermissions\Models;


use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
	protected $guarded = [];

    public function roles()
	{
	  return $this->belongsToMany(Role::class);
	}

	public function group(){
		return $this->belongsTo(PermissionGroup::class);
	}
}