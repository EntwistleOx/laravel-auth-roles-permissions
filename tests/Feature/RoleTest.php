<?php

namespace Tests\Feature;

use Tests\TestCase;
use Caffeinated\Shinobi\Models\Role;
use Caffeinated\Shinobi\Models\Permission;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RoleTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    #use WithoutMiddleware;

    /** @test */
    public function only_auth_user_with_proper_access_can_list_all_roles()
    {
        #$this->withoutExceptionHandling();
        $user = $this->assignRoleAndPermissionToSignedUser('roles.index');
        $this->assertTrue($user->hasPermissionTo(['roles.index']));
        $roles = factory(Role::class)->create();
        $this->get(route('roles.index'))
             ->assertOk()
             ->assertSee($roles->name)
             ->assertSee($roles->slug)
             ->assertSee($roles->description)
             ->assertSee($roles->special);
    }

    /** @test */
    public function auth_user_cannot_list_all_roles()
    {
        #$this->withoutExceptionHandling();
        $this->signIn();
        $roles = factory(Role::class)->create();
        $this->get(route('roles.index'))
             ->assertStatus(403);
    }

    /** @test */
    public function only_auth_user_with_proper_access_can_see_roles_create_form()
    {
        $user = $this->assignRoleAndPermissionToSignedUser('roles.create');
        $this->assertTrue($user->hasPermissionTo(['roles.create']));
        $this->get(route('roles.create'))
             ->assertOk()
             ->assertSee('Crear');
    }

    /** @test */
    public function auth_user_cannot_see_roles_create_form()
    {
        $this->signIn();
        $this->get(route('roles.create'))
             ->assertStatus(403);
    }

    /** @test */
    public function only_auth_user_with_proper_access_can_create_a_role()
    {
        #$this->withoutExceptionHandling();
        $user = $this->assignRoleAndPermissionToSignedUser('roles.store');
        $this->assertTrue($user->hasPermissionTo(['roles.store']));
        $attributes = [
            'name' => $this->faker->word,
            'slug' => $this->faker->slug,
            'description' => $this->faker->sentence,
            'special' => null
        ];
        $this->post('roles/store', $attributes);
        $count = Role::all()->count();
        $this->assertEquals(2,$count);
        $this->assertDatabaseHas('roles', $attributes);
    }

    /** @test */
    public function auth_user_cannot_create_a_role()
    {
        #$this->withoutExceptionHandling();
        $this->signIn();
        $attributes = [
            'name' => $this->faker->word,
            'slug' => $this->faker->slug,
            'description' => $this->faker->sentence,
            'special' => null
        ];
        $this->post('roles/store', $attributes)
             ->assertStatus(403);
    }

    /** @test */
    public function only_auth_user_with_proper_access_can_see_roles_edit_form()
    {
        $user = $this->assignRoleAndPermissionToSignedUser('roles.edit');
        $this->assertTrue($user->hasPermissionTo(['roles.edit']));
        $role = factory(Role::class)->create();
        $permission = factory(Permission::class)->create();
        $role->syncPermissions($permission->slug);
        $this->get(route('roles.edit',$role->id))
                ->assertOk()
                ->assertSee('Editar')
                ->assertSee($role->name)
                ->assertSee($permission->name);
    }

    /** @test */
    public function auth_user_cannot_see_roles_edit_form()
    {
        $this->signIn();
        $role = factory(Role::class)->create();
        $permission = factory(Permission::class)->create();
        $role->syncPermissions($permission->slug);
        $this->get(route('roles.edit',$role->id))
             ->assertStatus(403);
    }

    /** @test */
    public function only_auth_user_with_proper_access_can_update_a_role()
    {
        #$this->withoutExceptionHandling();
        $user = $this->assignRoleAndPermissionToSignedUser('roles.update');
        $this->assertTrue($user->hasPermissionTo(['roles.update']));
        $role = factory(Role::class)->create();
        $attributes = [
            'name' => 'changed',
            'slug' => 'changed',
            'description' => 'changed',
        ];
        $this->patch('roles/'.$role->id, $attributes);
        $this->assertDatabaseHas('roles', $attributes);
    }

    /** @test */
    public function auth_user_cannot_update_a_role()
    {
        #$this->withoutExceptionHandling();
        $this->signIn();
        $role = factory(Role::class)->create();
        $attributes = [
            'name' => 'changed',
            'slug' => 'changed',
            'description' => 'changed',
        ];
        $this->patch('roles/'.$role->id, $attributes)
             ->assertStatus(403);
    }

    /** @test */
    public function only_auth_user_with_proper_access_can_assign_permissions_to_a_rol()
    {
        #$this->withoutExceptionHandling();
        $user = $this->assignRoleAndPermissionToSignedUser('roles.update');
        $this->assertTrue($user->hasPermissionTo(['roles.update']));
        $role = factory(Role::class)->create();
        $permission = factory(Permission::class)->create();
        $attributes = [
            'name' => $role->name,
            'slug' => $role->name,
            'description' => $role->description,
            'permission' => $permission->slug
        ];
        $this->patch('roles/'.$role->id, $attributes);
        $this->assertDatabaseHas('permission_role', ['role_id' => $role->id]);
    }

    /** @test */
    public function auth_user_cannot_assign_permissions_to_a_rol()
    {
        #$this->withoutExceptionHandling();
        $this->signIn();
        $role = factory(Role::class)->create();
        $permission = factory(Permission::class)->create();
        $attributes = [
            'name' => $role->name,
            'slug' => $role->name,
            'description' => $role->description,
            'permission' => $permission->slug
        ];
        $this->patch('roles/'.$role->id, $attributes)
             ->assertStatus(403);
    }

    /** @test */
    public function only_auth_user_with_proper_access_can_delete_a_role()
    {
        $user = $this->assignRoleAndPermissionToSignedUser('roles.destroy');
        $this->assertTrue($user->hasPermissionTo(['roles.destroy']));
        $role = factory(Role::class)->create();
        $this->delete('roles/'.$role->id);
        $this->assertDatabaseMissing('roles',['id'=> $role->id]);
    }

    /** @test */
    public function auth_user_cannot_delete_a_role()
    {
        $this->signIn();
        $role = factory(Role::class)->create();
        $this->delete('roles/'.$role->id)
             ->assertStatus(403);
    }

    /** @test */
    public function a_role_requires_a_name()
    {
        $this->assignRoleAndPermissionToSignedUser('roles.store');
        $attributes = factory(Role::class)->raw(['name' => '']);
        $this->post('/roles/store', $attributes)->assertSessionHasErrors('name');
    }

    /** @test */
    public function a_role_requires_a_slug()
    {
        $this->assignRoleAndPermissionToSignedUser('roles.store');
        $attributes = factory(Role::class)->raw(['slug' => '']);
        $this->post('/roles/store', $attributes)->assertSessionHasErrors('slug');
    }

    /** @test */
    public function a_role_requires_a_description()
    {
        $this->assignRoleAndPermissionToSignedUser('roles.store');
        $attributes = factory(Role::class)->raw(['description' => '']);
        $this->post('/roles/store', $attributes)->assertSessionHasErrors('description');
    }
}
