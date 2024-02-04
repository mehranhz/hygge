<?php

namespace Tests\Integration\Repository;

use App\Models\User;
use App\Repository\Eloquent\UserRepository;
use Tests\TestCase;
 use Illuminate\Foundation\Testing\RefreshDatabase;


class UserRepositoryTest extends TestCase
{
    use RefreshDatabase;
    public function setUp(): void
    {
        parent::setUp();
        $this->userRepository = new UserRepository(new User());
        $this->user = $this->userRepository->create([
            'name'=>'test user',
            'email' => 'test@gmail.com',
            'phone' => '09210000000',
            'password' => '12345678',
        ]);
    }

    /** @test */
    public function create_method_returns_an_eloquent_user_instance()
    {
        $this->assertEquals(\App\Models\User::class,get_class($this->user));
    }

    /** @test */
    public function findByEmail_method_returns_an_entity_user_instance_if_user_exists()
    {
        $user = $this->userRepository->findByEmail('test@gmail.com');
        $this->assertEquals(\App\Entity\User::class,get_class($user));
    }

    /** @test */
    public function a_user_could_be_found_by_their_email()
    {
        $user = $this->userRepository->findByEmail('test@gmail.com');

        $this->assertEquals($this->user->email, $user->email);
    }


    /** @test */
    public function a_users_email_verification_date_could_be_updated()
    {
        $verification_date = now();
        $this->userRepository->updateVerificationDateByUserEmail($this->user->email,$verification_date->timestamp);

        $user = $this->userRepository->findByEmail($this->user->email);

        $this->assertEquals($user->getVerificationDate(),$verification_date);
    }
}
