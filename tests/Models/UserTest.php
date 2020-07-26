<?php
use PHPUnit\Framework\TestCase;
use App\Models\User;

class UserTest extends TestCase
{

    protected $user;

    public function setUp() : void
    {
        $this->user = new User();
    }

    public function testGetFirstName()
    {
        $testFirstName = 'Ko';

        $this->user->setFirstName( $testFirstName );

        $this->assertEquals( $this->user->getFirstName(), $testFirstName );

    }

    /**
     * @test
     */
    public function getLastName()
    {
        $testLastName = 'Ly';

        $this->user->setLastName( $testLastName );

        $this->assertEquals( $this->user->getLastName(), $testLastName );

    }
}