<?php

namespace Cardumen\LaravelPermissions\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
	
    public function users()
	{
	  return $this->belongsToMany(\App\User::class);
	}
	public function permissions()
	{
	  return $this->belongsToMany(Permission::class);
	}
}