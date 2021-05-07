<?php

/**
 * Результат попытки входа
 */
class LoginResult
{
    public string $token;

    public bool $is_success;

    public string $error_message;

    function __construct($token, $is_success, $error_message)
    {
        $this->token = $token;
        $this->is_success = $is_success;
        $this->error_message = $error_message;
    }
}