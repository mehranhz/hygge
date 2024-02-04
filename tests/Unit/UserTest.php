<?php

class UserTest extends \Tests\TestCase
{
    public function setUp(): void
    {
        $this->user = new \App\Entity\User('mehran', 'hosseinzadehmehran4@gmail.com','09211096707');
    }

    /** @test */
    public function a_user_has_a_name(){
        $this->assertEquals($this->user->getName(), 'mehran');
    }

    /** @test */
    public function a_user_has_an_email()
    {
        $this->assertEquals($this->user->getEmail(),'hosseinzadehmehran4@gmail.com');
    }

    /** @test */
    public function a_user_has_a_phone_number()
    {
        $this->assertEquals($this->user->getPhone(),'09211096707');
    }

    /** @test */

    public function a_user_has_a_verification_date_for_their_email(){
        $this->assertNull($this->user->getVerificationDate());
    }

}
