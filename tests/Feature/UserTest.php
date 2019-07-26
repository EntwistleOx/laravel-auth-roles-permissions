<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Caffeinated\Shinobi\Models\Role;
use Illuminate\Support\Facades\Hash;
use Caffeinated\Shinobi\Models\Permission;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function only_auth_user_with_proper_access_can_list_all_users()
    {
        #$this->withoutExceptionHandling();
        # Given I have an auth user with proper role and permission
        $user = $this->assignRoleAndPermissionToSignedUser('users.index');
        $this->assertTrue($user->hasPermissionTo(['users.index']));
        $users = factory(User::class)->create();
        $this->get(route('users.index'))
             ->assertOk()
             ->assertSee($users->name)
             ->assertSee($users->username);
    }

    /** @test */
    public function auth_user_cannot_list_all_users()
    {
        #$this->withoutExceptionHandling();
        # Given I have an auth user
        $this->signIn();
        $users = factory(User::class)->create();
        $this->get(route('users.index'))
             ->assertStatus(403);
    }

    /** @test */
    public function only_auth_user_with_proper_access_can_see_users_create_form()
    {
        #$this->withoutExceptionHandling();
        $user = $this->assignRoleAndPermissionToSignedUser('users.create');
        $this->assertTrue($user->hasPermissionTo(['users.create']));
        $this->get(route('users.create'))
             ->assertOk()
             ->assertSee('Crear');
    }

    /** @test */
    public function auth_user_cannot_see_users_create_form()
    {
        #$this->withoutExceptionHandling();
        # Given I have an auth user
        $this->signIn();
        $this->get(route('users.create'))
             ->assertStatus(403);
    }

    /** @test */
    public function only_auth_user_with_proper_access_can_store_an_user()
    {
        #$this->withoutExceptionHandling();
        $user = $this->assignRoleAndPermissionToSignedUser('users.store');
        $this->assertTrue($user->hasPermissionTo(['users.store']));
        $name = $this->faker->firstName . ' ' . $this->faker->lastName;
        $username = iconv('utf-8', 'ascii//TRANSLIT', $name);
        $username = str_replace('\'','',$username);
        $username = str_replace('~','',$username);
        $username = str_replace(' ','',$username);
        $username = strtolower($username);
        $attributes = [
            'name' => $name,
            'username' => $username,
            'password' => 'password' // password
        ];

        $this->post('users/store', $attributes);

        $count = User::all()->count();
        $this->assertEquals(2,$count);
        $data = [
            'name' => $name,
            'username' => $username,
        ];
        $this->assertDatabaseHas('users', $data);
    }

    /** @test */
    public function auth_user_cannot_store_an_user()
    {
        #$this->withoutExceptionHandling();
        $this->signIn();
        $attributes = [
            'name' => 'name',
            'username' => 'username',
            'password' => 'password'
        ];
        $this->post('users/store', $attributes)
             ->assertStatus(403);
    }

    /** @test */
    public function only_auth_user_with_proper_access_can_see_users_edit_form()
    {
        #$this->withoutExceptionHandling();
        $admin = $this->assignRoleAndPermissionToSignedUser('users.edit');
        $this->assertTrue($admin->hasPermissionTo(['users.edit']));
        $user = factory(User::class)->create();
        $role = factory(Role::class)->create();
        $user->syncRoles($role->slug);
        $this->get(route('users.edit',$user->id))
             ->assertOk()
             ->assertSee('Editar')
             ->assertSee($user->name)
             ->assertSee($role->name);
    }

    /** @test */
    public function auth_user_cannot_see_users_edit_form()
    {
        #$this->withoutExceptionHandling();
        $this->signIn();
        $user = factory(User::class)->create();
        $role = factory(Role::class)->create();
        $this->get(route('users.edit',$user->id))
             ->assertStatus(403);
    }

    /** @test */
    public function only_auth_user_with_proper_access_can_update_an_user()
    {
        $this->withoutExceptionHandling();
        $admin = $this->assignRoleAndPermissionToSignedUser('users.update');
        $user = factory(User::class)->create();
        $attributes = [
            'name' => 'changed',
            'username' => 'changed'
        ];
        $this->patch('users/'.$user->id, $attributes);
        $data = [
            'name' => 'changed',
            'username' => 'changed',
        ];
        $this->assertTrue($admin->hasPermissionTo(['users.update']));
        $this->assertDatabaseHas('users', $data);
    }

    /** @test */
    public function auth_user_cannot_update_an_user()
    {
        #$this->withoutExceptionHandling();
        $this->signIn();
        $user = factory(User::class)->create();
        $attributes = [
            'name' => 'changed',
            'username' => 'changed'
        ];
        $this->patch('users/'.$user->id, $attributes)
             ->assertStatus(403);
    }

    /** @test */
    public function only_auth_user_with_proper_access_can_assign_roles_to_an_user()
    {
        #$this->withoutExceptionHandling();
        $admin = $this->assignRoleAndPermissionToSignedUser('users.update');
        $user = factory(User::class)->create();
        $role = factory(Role::class)->create();
        $attributes = [
            'name' => $user->name,
            'username' => $user->username,
            'role' => $role->slug,
        ];

        $this->patch('users/'.$user->id, $attributes);
        $this->assertTrue($admin->hasPermissionTo(['users.update']));
        $this->assertTrue($user->hasRole($role->slug));
        $this->assertDatabaseHas('role_user', ['user_id' => $user->id]);
    }

    /** @test */
    public function auth_user_cannot_assign_roles_to_an_user()
    {
        #$this->withoutExceptionHandling();
        $this->signIn();
        $user = factory(User::class)->create();
        $role = factory(Role::class)->create();
        $attributes = [
            'name' => $user->name,
            'username' => $user->username,
            'role' => $role->slug,
        ];
        $this->patch('users/'.$user->id, $attributes)
             ->assertStatus(403);
    }

    /** @test */
    public function only_auth_user_with_proper_access_can_delete_an_user()
    {
        #$this->withoutExceptionHandling();
        $admin = $this->assignRoleAndPermissionToSignedUser('users.destroy');
        $user = factory(User::class)->create();
        $this->delete('users/'.$user->id);
        $this->assertTrue($admin->hasPermissionTo(['users.destroy']));
        $this->assertDatabaseMissing('users',['id'=> $user->id]);
    }

    /** @test */
    public function auth_user_cannot_delete_an_user()
    {
        #$this->withoutExceptionHandling();
        $this->signIn();
        $user = factory(User::class)->create();
        $this->delete('users/'.$user->id)
             ->assertStatus(403);
    }

    /** @test */
    public function a_user_requires_a_name()
    {
        $this->assignRoleAndPermissionToSignedUser('users.store');
        $attributes = factory(User::class)->raw(['name' => '']);
        $this->post('/users/store', $attributes)->assertSessionHasErrors('name');
    }

    /** @test */
    public function a_user_requires_an_username()
    {
        $this->assignRoleAndPermissionToSignedUser('users.store');
        $attributes = factory(User::class)->raw(['username' => '']);
        $this->post('/users/store', $attributes)->assertSessionHasErrors('username');
    }

    /** @test */
    public function a_user_requires_a_password()
    {
        $this->assignRoleAndPermissionToSignedUser('users.store');
        $attributes = factory(User::class)->raw(['password' => '']);
        $this->post('/users/store', $attributes)->assertSessionHasErrors('password');
    }

    /** @test */
    public function a_user_password_may_be_updated_only_by_auth_user_with_proper_access()
    {
        #$this->withoutExceptionHandling();
        $admin = $this->assignRoleAndPermissionToSignedUser('users.update');
        $user = factory(User::class)->create();
        $newPassword = 'changed';
        $attributes = [
            'password' => $newPassword,
            'password_confirmation' => $newPassword
        ];
        $this->patch('password/'.$user->id, $attributes);
        $this->assertTrue(\Hash::check($newPassword, $user->fresh()->password));
    }

    /** @test */
    public function a_user_password_cannot_be_updated_by_auth_user()
    {
        #$this->withoutExceptionHandling();
        $this->signIn();
        $user = factory(User::class)->create();
        $newPassword = 'changed';
        $attributes = [
            'password' => $newPassword,
            'password_confirmation' => $newPassword
        ];
        $this->patch('password/'.$user->id, $attributes)
             ->assertStatus(403);
    }
}
