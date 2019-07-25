<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_user_can_view_a_login_form()
    {
        $this->get('/login')
             ->assertStatus(200)
             ->assertViewIs('auth.login')
             ->assertSee('Acceder');
    }

    /** @test */
    public function auth_user_cannot_view_a_login_form()
    {
        $this->signIn();
        $this->get('/login')
             ->assertRedirect('home');
    }

    /** @test */
    public function guest_user_can_login_with_correct_credentials()
    {
        $user = factory(User::class)->create([
            'password' => bcrypt($password = 'correct'),
        ]);
        $this->post('/login', [
            'username' => $user->username,
            'password' => $password
        ])->assertRedirect('home');
        $this->assertCredentials([
             'username' => $user->username,
             'password' => 'correct'
        ]);
        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function guest_user_cannot_login_with_incorrect_password()
    {
        $user = factory(User::class)->create([
            'password' => bcrypt('correct'),
        ]);
        $this->from('/login')->post('/login', [
            'username' => $user->username,
            'password' => 'incorrect'
        ])->assertRedirect('/login');
        $this->assertInvalidCredentials([
             'username' => $user->username,
             'password' => 'incorrect'
        ]);
        $this->assertGuest();
    }

    /** @test */
    public function guest_user_cannot_login_with_incorrect_username()
    {
        $user = factory(User::class)->create();
        $this->from('/login')->post('/login', [
            'username' => 'invalidUsername',
            'password' => 'password'
        ])->assertRedirect('/login');
        $this->assertInvalidCredentials([
              'username' => 'invalidUsername',
              'password' => 'password'
        ]);
        $this->assertGuest();
    }
}
