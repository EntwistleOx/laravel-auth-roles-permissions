<?php

namespace Tests;

use Caffeinated\Shinobi\Models\Role;
use Caffeinated\Shinobi\Models\Permission;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function signIn($user = null)
    {
        $user = $user ?: factory('App\User')->create();
        $this->actingAs($user);
        return $user;
    }

    protected function assignRoleAndPermissionToSignedUser($permission = null){
        # Signed user
        $user = $this->signIn();

        # Role with all access
        Role::create([
            'name' => 'Admin',
            'slug' => 'admin',
            'special' => 'all-access'
        ]);

        # Permmision to action
        Permission::create([
            'name' => 'Permission',
            'slug' => $permission,
        ]);

        # assing role to auth user
        $user->syncRoles('admin');

        return $user;
    }
}
