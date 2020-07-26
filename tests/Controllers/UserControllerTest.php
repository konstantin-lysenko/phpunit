<?php
use PHPUnit\Framework\TestCase;
use App\Controllers\UserController;
use App\Models\User;
use App\Models\Database;

class UserControllerTest extends TestCase
{

    private $user;

    private $database;

    private $userController;

    private $stub;

    public function setUp() : void
    {
        $this->database = new Database();
        $this->user = new User(1);

        $this->stub = $this->createStub( Database::class );

        $this->stub->method('getByID')
                    ->willReturn(new User(1));
    }

    /**
     * @test
     * stub
     * */
    public function testIfGetByIDReturnsCorrectUser()
    {
        $this->assertEquals( $this->user, $this->stub->getByID(1) );
    }
}