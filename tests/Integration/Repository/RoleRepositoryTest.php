<?php

namespace Tests\Integration\Repository;

use App\Repository\Eloquent\RoleRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class RoleRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->roleRepository = new RoleRepository(new Role());
        $this->role = $this->roleRepository->create([
            'name' => 'author'
        ]);
    }

    /** @test */
    public function create_method_returns_a_role()
    {
        $this->assertEquals(Role::class, get_class($this->role));
    }
}
