<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Caffeinated\Shinobi\Models\Permission;

class PermissionTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    #use WithoutMiddleware;

    /** @test */
    public function auth_user_can_list_all_permissions()
    {
        $this->withoutExceptionHandling();
        $user = $this->signIn();

        $permission = factory(Permission::class)->create();

        $this->get(route('permissions.index'))
             ->assertOk()
             ->assertSee($permission->name)
             ->assertSee($permission->slug)
             ->assertSee($permission->description);
    }

    /** @test */
    public function auth_user_can_see_permissions_create_form()
    {
        $this->signIn();

        $this->get(route('permissions.create'))
             ->assertOk()
             ->assertSee('Crear');
    }

    /** @test */
    public function auth_user_can_create_a_permission()
    {
        $this->withoutExceptionHandling();

        $this->signIn();

        $attributes = [
            'name' => $this->faker->word,
            'slug' => $this->faker->slug,
            'description' => $this->faker->sentence
        ];

        $this->post('permissions', $attributes);

        $count = Permission::all()->count();
        $this->assertEquals(1,$count);
        $this->assertDatabaseHas('permissions', $attributes);
    }

    /** @test */
    public function auth_user_can_see_permissions_edit_form()
    {
        $this->signIn();
        $permission = factory(Permission::class)->create();
        $this->get(route('permissions.edit',$permission->id))
                ->assertOk()
                ->assertSee('Editar');
    }

    /** @test */
    public function auth_user_can_update_a_permission()
    {
        $this->withoutExceptionHandling();

        $this->signIn();

        $permission = factory(Permission::class)->create();

        $attributes = [
            'name' => 'changed',
            'slug' => 'changed',
            'description' => 'changed'
        ];

        $this->patch('permissions/'.$permission->id, $attributes);

        $this->assertDatabaseHas('permissions', $attributes);
    }

    /** @test */
    public function auth_user_can_delete_a_permission()
    {
        $this->signIn();
        $permission = factory(Permission::class)->create();
        $this->delete('permissions/'.$permission->id);
        $this->assertDatabaseMissing('permissions',['id'=> $permission->id]);
    }

    /** @test */
    public function a_permission_requires_a_name()
    {
        $this->signIn();
        $attributes = factory(Permission::class)->raw(['name' => '']);
        $this->post('/permissions', $attributes)->assertSessionHasErrors('name');
    }

    /** @test */
    public function a_permission_requires_a_slug()
    {
        $this->signIn();
        $attributes = factory(Permission::class)->raw(['slug' => '']);
        $this->post('/permissions', $attributes)->assertSessionHasErrors('slug');
    }

    /** @test */
    public function a_permission_requires_a_description()
    {
        $this->signIn();
        $attributes = factory(Permission::class)->raw(['description' => '']);
        $this->post('/permissions', $attributes)->assertSessionHasErrors('description');
    }
}
