<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Caffeinated\Shinobi\Models\Role;
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
        $this->withoutExceptionHandling();
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
        $this->withoutExceptionHandling();

        $this->signIn();

        $user = factory(User::class)->create();

        $attributes = [
            'name' => 'changed',
            'username' => 'changed',
            'password' => 'changed'
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

    #TODO
    #validate request test
}
