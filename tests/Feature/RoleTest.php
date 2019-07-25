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
        $this->assignRoleAndPermissionToSignedUser('roles.index');

        $roles = factory(Role::class)->create();

        $this->get(route('roles.index'))
             ->assertOk()
             ->assertSee($roles->name)
             ->assertSee($roles->slug)
             ->assertSee($roles->description)
             ->assertSee($roles->special);
    }

    /** @test */
    public function auth_user_can_see_roles_create_form()
    {
        $this->signIn();

        $this->get(route('roles.create'))
             ->assertOk()
             ->assertSee('Crear');
    }

    /** @test */
    public function auth_user_can_create_a_role()
    {
        $this->withoutExceptionHandling();

        $this->signIn();

        $attributes = [
            'name' => $this->faker->word,
            'slug' => $this->faker->slug,
            'description' => $this->faker->sentence,
            'special' => null
        ];

        $this->post('roles', $attributes);

        $count = Role::all()->count();
        $this->assertEquals(1,$count);
        $this->assertDatabaseHas('roles', $attributes);
    }

    /** @test */
    public function auth_user_can_see_roles_edit_form()
    {
        $this->signIn();
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
    public function auth_user_can_update_a_role()
    {
        #$this->withoutExceptionHandling();

        $this->signIn();

        $role = factory(Role::class)->create();

        $attributes = [
            'name' => 'changed',
            'slug' => 'changed',
            'description' => 'changed',
            'special' => null
        ];

        $this->patch('roles/'.$role->id, $attributes);

        $this->assertDatabaseHas('roles', $attributes);
    }

    /** @test */
    public function auth_user_can_assign_permissions_to_a_rol()
    {
        $this->withoutExceptionHandling();
        $this->signIn();
        $role = factory(Role::class)->create();
        $permission = factory(Permission::class)->create();
        $role->syncPermissions($permission->slug);
        #$response = $role->can($permission->slug);
        $this->assertDatabaseHas('permission_role', ['role_id' => $role->id]);
    }

    /** @test */
    public function auth_user_can_delete_a_role()
    {
        $this->signIn();
        $role = factory(Role::class)->create();
        $this->delete('roles/'.$role->id);
        $this->assertDatabaseMissing('roles',['id'=> $role->id]);
    }

    /** @test */
    public function a_role_requires_a_name()
    {
        $this->signIn();
        $attributes = factory(Role::class)->raw(['name' => '']);
        $this->post('/roles', $attributes)->assertSessionHasErrors('name');
    }

    /** @test */
    public function a_role_requires_a_slug()
    {
        $this->signIn();
        $attributes = factory(Role::class)->raw(['slug' => '']);
        $this->post('/roles', $attributes)->assertSessionHasErrors('slug');
    }

    /** @test */
    public function a_role_requires_a_description()
    {
        $this->signIn();
        $attributes = factory(Role::class)->raw(['description' => '']);
        $this->post('/roles', $attributes)->assertSessionHasErrors('description');
    }
}
