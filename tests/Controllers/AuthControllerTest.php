<?php
use PHPUnit\Framework\TestCase;
use App\Controllers\AuthController;
use App\Services\UserService;
use App\Services\EmailService;

class AuthControllerTest extends TestCase
{
    /**
     * @test
     * */
    public function ifEmptyUsername()
    {

        $this->controller = new AuthController( (new UserService), (new EmailService) );
        $request = (object) [
            'username' => '   ',
            'password' => 1
        ];

        $res = $this->controller->login($request);

        $this->assertEquals("Please provide username and password.", $res);
    }

    /**
     * @test
     * */
    public function ifEmptyPassword()
    {
        $this->stub = $this->createStub( UserService::class );

        $this->stub->method('get')
                    ->willReturn(true);

        $this->controller = new AuthController( $this->stub );

        $request = (object) [
            'username' => 'abracadabra',
            'password' => ''
        ];

        $res = $this->controller->login($request);

        $this->assertEquals("Please provide username and password.", $res);
    }

    /**
     * @test
     * */
    public function ifUncorrectPassword()
    {
        $this->stub = $this->createStub( UserService::class );

        $this->stub->method('get')
                    ->willReturn(true);
        $this->stub->method('login')
                    ->willReturn(false);

        $this->controller = new AuthController( $this->stub );

        $this->assertSame( true, $this->stub->get());
        $this->assertSame( false, $this->stub->login());

        $request = (object) [
            'username' => 'abracadabra',
            'password' => '1'
        ];

        $res = $this->controller->login($request);

        $this->assertEquals("Please provide correct username and password.", $res);
    }

    /**
     * @test
     * */
    public function ifCorrectPasswordAndLogin()
    {
        $this->stub = $this->createStub( UserService::class );

        $this->stub->method('get')
                    ->willReturn(true);
        $this->stub->method('login')
                    ->willReturn(true);

        $this->controller = new AuthController( $this->stub );

        $this->assertSame( true, $this->stub->get());
        $this->assertSame( true, $this->stub->login());

        $request = (object) [
            'username' => 'abracadabra',
            'password' => 1
        ];

        $res = $this->controller->login($request);

        $this->assertEquals("Success!", $res);
    }
}