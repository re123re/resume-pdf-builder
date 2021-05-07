<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/data_access/security/UserLoginService.php';

activate();

function activate()
{
    header("Content-type: application/json; charset=utf-8");

    $phone_number = $_POST["phone_number"];
    $userLoginService = new UserLoginService();
    $userLoginService->activateSubscription($phone_number);

    echo json_encode(array(is_success => true));
}