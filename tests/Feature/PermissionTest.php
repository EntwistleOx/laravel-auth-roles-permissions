<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Caffeinated\Shinobi\Models\Permission;

class PermissionTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function only_auth_user_with_proper_access_can_list_all_permissions()
    {
        #$this->withoutExceptionHandling();
        $user = $this->assignRoleAndPermissionToSignedUser('permissions.index');
        $this->assertTrue($user->hasPermissionTo(['permissions.index']));
        $permission = factory(Permission::class)->create();
        $this->get(route('permissions.index'))
             ->assertOk()
             ->assertSee($permission->name)
             ->assertSee($permission->slug)
             ->assertSee($permission->description);
    }

    /** @test */
    public function auth_user_cannot_list_all_permissions()
    {
        #$this->withoutExceptionHandling();
        $this->signIn();
        $permission = factory(Permission::class)->create();
        $this->get(route('permissions.index'))
             ->assertStatus(403);
    }

    /** @test */
    public function only_auth_user_with_proper_access_can_see_permissions_create_form()
    {
        $user = $this->assignRoleAndPermissionToSignedUser('permissions.create');
        $this->assertTrue($user->hasPermissionTo(['permissions.create']));
        $this->get(route('permissions.create'))
             ->assertOk()
             ->assertSee('Crear');
    }

    /** @test */
    public function auth_user_cannot_see_permissions_create_form()
    {
        $this->signIn();
        $this->get(route('permissions.create'))
             ->assertStatus(403);
    }

    /** @test */
    public function only_auth_user_with_proper_access_can_create_a_permission()
    {
        #$this->withoutExceptionHandling();
        $user = $this->assignRoleAndPermissionToSignedUser('permissions.store');
        $this->assertTrue($user->hasPermissionTo(['permissions.store']));
        $attributes = [
            'name' => $this->faker->word,
            'slug' => $this->faker->slug,
            'description' => $this->faker->sentence
        ];
        $this->post('permissions/store', $attributes);
        $count = Permission::all()->count();
        $this->assertEquals(2,$count);
        $this->assertDatabaseHas('permissions', $attributes);
    }

    /** @test */
    public function auth_user_cannot_create_a_permission()
    {
        #$this->withoutExceptionHandling();
        $this->signIn();
        $attributes = [
            'name' => $this->faker->word,
            'slug' => $this->faker->slug,
            'description' => $this->faker->sentence
        ];
        $this->post('permissions/store', $attributes)
             ->assertStatus(403);
    }

    /** @test */
    public function only_auth_user_with_proper_access_can_see_permissions_edit_form()
    {
        $user = $this->assignRoleAndPermissionToSignedUser('permissions.edit');
        $this->assertTrue($user->hasPermissionTo(['permissions.edit']));
        $permission = factory(Permission::class)->create();
        $this->get(route('permissions.edit',$permission->id))
                ->assertOk()
                ->assertSee('Editar');
    }

    /** @test */
    public function auth_user_cannot_see_permissions_edit_form()
    {
        $this->signIn();
        $permission = factory(Permission::class)->create();
        $this->get(route('permissions.edit',$permission->id))
             ->assertStatus(403);
    }

    /** @test */
    public function only_auth_user_with_proper_access_can_update_a_permission()
    {
        #$this->withoutExceptionHandling();
        $user = $this->assignRoleAndPermissionToSignedUser('permissions.update');
        $this->assertTrue($user->hasPermissionTo(['permissions.update']));
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
    public function auth_user_cannot_update_a_permission()
    {
        #$this->withoutExceptionHandling();
        $this->signIn();
        $permission = factory(Permission::class)->create();
        $attributes = [
            'name' => 'changed',
            'slug' => 'changed',
            'description' => 'changed'
        ];
        $this->patch('permissions/'.$permission->id, $attributes)
             ->assertStatus(403);
    }

    /** @test */
    public function only_auth_user_with_proper_access_can_delete_a_permission()
    {
        #$this->withoutExceptionHandling();
        $user = $this->assignRoleAndPermissionToSignedUser('permissions.destroy');
        $this->assertTrue($user->hasPermissionTo(['permissions.destroy']));
        $permission = factory(Permission::class)->create();
        $this->delete('permissions/'.$permission->id);
        $this->assertDatabaseMissing('permissions',['id'=> $permission->id]);
    }

    /** @test */
    public function auth_user_cannot_delete_a_permission()
    {
        #$this->withoutExceptionHandling();
        $this->signIn();
        $permission = factory(Permission::class)->create();
        $this->delete('permissions/'.$permission->id)
             ->assertStatus(403);
    }

    /** @test */
    public function a_permission_requires_a_name()
    {
        #$this->withoutExceptionHandling();
        $this->assignRoleAndPermissionToSignedUser('permissions.store');
        $attributes = factory(Permission::class)->raw(['name' => '']);
        $this->post('/permissions/store', $attributes)->assertSessionHasErrors('name');
    }

    /** @test */
    public function a_permission_requires_a_slug()
    {
        $this->assignRoleAndPermissionToSignedUser('permissions.store');
        $attributes = factory(Permission::class)->raw(['slug' => '']);
        $this->post('/permissions/store', $attributes)->assertSessionHasErrors('slug');
    }

    /** @test */
    public function a_permission_requires_a_description()
    {
        $this->assignRoleAndPermissionToSignedUser('permissions.store');
        $attributes = factory(Permission::class)->raw(['description' => '']);
        $this->post('/permissions/store', $attributes)->assertSessionHasErrors('description');
    }
}
