<?php

namespace Cardumen\LaravelPermissions\Models;


use Illuminate\Database\Eloquent\Model;

class PermissionGroup extends Model
{
	protected $guarded = [];
	protected $table = 'permission_groups';

    public function permissions()
	{
	  return $this->hasMany(Permission::class,'permission_group_id');
	}
}