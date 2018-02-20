<?php

namespace Cardumen\LaravelPermissions\Commands;

use Illuminate\Console\Command;
use DB;
use Cardumen\LaravelPermissions\Models\Permission;
use Cardumen\LaravelPermissions\Models\PermissionGroup;

class PermissionsManager extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permissions:manager';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create permissions';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $tipo = $this->choice('What type of permission are you creating?',['RESTfull','Route','Custom','Group'],1);
        $description = $this->ask('Please fill in a description for the permission');

        if($tipo == 'Group'){
            PermissionGroup::create([
                'group' => $description
            ]);
            $this->info('permissions group created!');
        } else {
            $groups = PermissionGroup::orderBy('group')->select('id','group')->get()->toArray();
            $group_id = $this->choice('Please select the group for this permission',$groups,1);
        }

        if($tipo == 'RESTfull'){
            $model = $this->ask('Please fill in the model class (including the namespace) ');
            $route = $this->ask('Please fill in the base route name for this model ');
            
            $restmethods = ['r'=>['index','show'], 'w' => ['edit','create','store','update','destroy']];

            DB::transaction(function () use ($model,$route,$restmethods,$description,$group_id) {
                foreach($restmethods as $rw=> $rmrw){
                    foreach($rmrw as $rm){
                        $name = explode("\\",$model);

                        Permission::create([
                            "description" => $description,
                            "permission"=> end($name).".".$rm,
                            "model"=>$model,
                            "route"=>$route.".".$rm,
                            "rw" => $rw,
                            "group_id" => $group_id, 
                        ]);
                    } 
                }
                

            });
            $this->info('permissions created!');


        } 

        if($tipo == 'Route'){
            $name = $this->ask('Please fill in the name for this permission ');
            $route = $this->ask('Please fill in the route name for this permission ');
            $ro = $this->confirm('Is this a read-only method?');
                    Permission::create([
                            "description" => $description,
                            "permission"=> $name,
                            "route"=>$route,
                            "rw" => ($ro) ? 'r': 'w',
                            "group_id" => $group_id, 
                        ]);
            $this->info('permission created!');
        }

        if($tipo == 'Custom'){
            $name = $this->ask('Please fill in the name for this permission ');
            
            $route = $this->ask('Please fill in the route name for this permission');
            $model = $this->ask('Please fill in the model class (including the namespace)');
            $ro = $this->confirm('Is this a read-only method?');
                    Permission::create([
                            "description" => $description,
                            "permission"=> $name,
                            "model"=>$model,
                            "route"=>$route,
                            "rw" => ($ro) ? 'r': 'w',
                            "group_id" => $group_id,
                        ]);
            $this->info('permission created!');
        }
        
    }
}
