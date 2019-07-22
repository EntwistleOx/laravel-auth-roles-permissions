<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Caffeinated\Shinobi\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class UserTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    #use WithoutMiddleware;

    /** @test */
    public function auth_user_can_list_all_users()
    {
        #$this->withoutExceptionHandling();
        $user = $this->signIn();

        $users = factory(User::class)->create();

        $this->get(route('users.index'))
             ->assertOk()
             ->assertSee($users->name)
             ->assertSee($users->username);
    }


    /** @test */
    public function auth_user_can_see_users_create_form()
    {
        $this->signIn();

        $this->get(route('users.create'))
             ->assertOk()
             ->assertSee('Crear');
    }

    /** @test */
    public function auth_user_can_create_an_user()
    {
        #$this->withoutExceptionHandling();

        $this->signIn();

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

        $this->post('users', $attributes);

        $count = User::all()->count();
        $this->assertEquals(2,$count);
        $data = [
            'name' => $name,
            'username' => $username,
        ];
        $this->assertDatabaseHas('users', $data);
    }

    /** @test */
    public function auth_user_can_see_users_edit_form()
    {
        #$this->withoutExceptionHandling();
        $this->signIn();
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
    public function auth_user_can_update_an_user()
    {
        #$this->withoutExceptionHandling();

        $auth = $this->signIn();

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

        $this->assertDatabaseHas('users', $data);
    }

    /** @test */
    public function auth_user_can_assign_roles_to_an_user()
    {
        $this->withoutExceptionHandling();
        $this->signIn();
        $user = factory(User::class)->create();
        $role = factory(Role::class)->create();
        $user->syncRoles($role->slug);
        $response = $user->hasRole($role->slug);
        $this->assertTrue($response);
        $this->assertDatabaseHas('role_user', ['user_id' => $user->id]);
    }

    /** @test */
    public function auth_user_can_delete_an_user()
    {
        $this->signIn();
        $user = factory(User::class)->create();
        $this->delete('users/'.$user->id);
        $this->assertDatabaseMissing('users',['id'=> $user->id]);
    }

    /** @test */
    public function a_user_requires_a_name()
    {
        $this->signIn();
        $attributes = factory(User::class)->raw(['name' => '']);
        $this->post('/users', $attributes)->assertSessionHasErrors('name');
    }

    /** @test */
    public function a_user_requires_an_username()
    {
        $this->signIn();
        $attributes = factory(User::class)->raw(['username' => '']);
        $this->post('/users', $attributes)->assertSessionHasErrors('username');
    }

    /** @test */
    public function a_user_requires_a_password()
    {
        $this->signIn();
        $attributes = factory(User::class)->raw(['password' => '']);
        $this->post('/users', $attributes)->assertSessionHasErrors('password');
    }

    /** @test */
    public function a_password_may_be_updated()
    {
        $this->withoutExceptionHandling();
        $this->signIn();
        $user = factory(User::class)->create();

        $newPassword = 'changed';

        $attributes = [
            'password' => $newPassword,
            'password_confirmation' => $newPassword
        ];

        $this->patch('users/'.$user->id.'/password', $attributes);

        #dd($user->password);
        $this->assertTrue(\Hash::check($newPassword, $user->fresh()->password));
    }
}
