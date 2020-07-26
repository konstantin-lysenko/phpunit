<?php

namespace App\Controllers;

use App\Services\EmailService;
use Exception;

class AuthController
{
    private $userService;

    private $emailService;

    public function __construct( $userService = null, $emailService = null )
    {
        $this->userService = $userService;
        $this->emailService = $emailService;
    }

    public function login( $request )
    {
        $username = trim($request->username ?? null);
        $pwd = trim($request->password ?? null);

        if ( empty($username) || empty($pwd) ) {
            return 'Please provide username and password.';
        }

        $isCreatedUser = $this->userService->get( $username );
        $isPasswordCorrect = $this->userService->login( $username, $pwd );

        if ( $isCreatedUser && $isPasswordCorrect ) {
            return 'Success!';
        }

        return 'Please provide correct username and password.';
    }

    public function restorePassword( $email )
    {
        $users = $this->userService->getAll();

        foreach ($users as $key => $value) {
            if( $email === $key ) {

                $this->sendRestoringMessage('Your password changed.', $email);
            }
        }

        return 'You are not registered.';
    }

    public function sendRestoringMessage( $msg, $email )
    {
        $this->emailService->setMessage( $msg );

        $this->emailService->send($email);

        if( ! $this->emailService ){
            return false;
        }

        return true;
    }

    public function getByEmail( $email )
    {
        if( ! filter_var($email, FILTER_VALIDATE_EMAIL) ){
            throw new \Exception('Email isn\'t correct');
        }

        $user = $this->userService->get( $email );

        if( ! empty( $user ) ){
            return $user;
        }

        return false;
    }
}