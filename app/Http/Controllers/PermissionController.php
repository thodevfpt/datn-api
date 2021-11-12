<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionController extends Controller
{
    public function run()
    {

        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'delete product']);
        Permission::create(['name' => 'delete category']);
        Permission::create(['name' => 'delete slide']);
        Permission::create(['name' => 'delete blog']);
        Permission::create(['name' => 'delete user']);
        Permission::create(['name' => 'delete comment']);
        
        // create roles and assign existing permissions
        $role1 = Role::create(['name' => 'Admin']);
        $role2 = Role::create(['name' => 'manager order']);
        $role3 = Role::create(['name' => 'manager content']);
        $role4 = Role::create(['name' => 'manager comment']);
        $role5 = Role::create(['name' => 'manager user']);
      
        // create new user and give role
        $user1=User::find(1);
        $user1->assignRole($role1);
        $user2=User::find(2);
        $user2->assignRole($role2);
        
        dd('done');

    }
}
