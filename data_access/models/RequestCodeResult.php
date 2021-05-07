<?php

/**
 * Результат попытки получения проверочного кода
 */
class RequestCodeResult
{
    public string $ucaller_id;

    public bool $is_success;

    public string $error_message;

    function __construct($ucaller_id, $is_success, $error_message)
    {
        $this->ucaller_id = $ucaller_id;
        $this->is_success = $is_success;
        $this->error_message = $error_message;
    }
}