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

    /**
     * @test
     * */
    public function ifEmailIsNotCorrect()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Email isn\'t correct');

        $this->controller = new AuthController( (new UserService), (new EmailService) );
        $email = 'asd@';

        $res = $this->controller->getByEmail($email);
    }

    /**
     * @test
     * @dataProvider providerUsers
     * */
    public function isRestoringFilterUsersCorrectly( $users )
    {
        $email = 'test@test.com';

        $this->userServiceMock = $this->createMock( UserService::class );
        $this->userServiceMock->expects($this->once())
                                ->method('getAll')
                                ->will( $this->returnValue($users) );

        $this->controller = new AuthController( $this->userServiceMock );
        $res = $this->controller->restorePassword( $email );

        $this->assertEquals('You are not registered.',$res);

    }

    public function providerUsers() {
        return array(
            [['user1' => 1]],
            [['test@test.co' => 'afff']],
            [['hot@hot.net' => 'asdsad']],
        );
    }

    /**
     * @test
     * */
    public function isRestoringMessageSends()
    {
        $this->mock = $this->getMockBuilder( EmailService::class )

                            ->getMock();

        $this->mock->expects($this->at(0))->method('setMessage')->with('message');
        $this->mock->expects($this->at(1))->method('send')->with('t@t.com');

        $this->controller = new AuthController( '', $this->mock );
        $res = $this->controller->sendRestoringMessage( 'message', 't@t.com' );

        $this->assertEquals(true,$res);

    }
}