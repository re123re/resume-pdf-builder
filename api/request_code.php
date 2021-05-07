<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/data_access/security/UserLoginService.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/data_access/models/RequestCodeResult.php';

request_code();

function request_code()
{
    header("Content-type: application/json; charset=utf-8");

    $phone_number = $_POST["phone_number"];
    if ((is_null($phone_number) || $phone_number == ``))
    {
        echo json_encode(new RequestCodeResult("", false, 'Не указан номер телефона'));
    }

    $userLoginService = new UserLoginService();
    if (!$userLoginService->isRegistered($phone_number))
    {
        echo json_encode(new RequestCodeResult("", false, 'Пользователь не зарегистрирован'));
        return;
    }

    $config = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . '/config.ini');
    $service_id = $config['service_id'];
    $secret_key = $config['private_key'];

    $request = file_get_contents('https://api.ucaller.ru/v1.0/initCall?service_id=' . $service_id . '&key=' . $secret_key . '&phone=' . $phone_number);
    $response = json_decode($request, true);

    // debug
    // $testid = array("ucaller_id"=> 12345678);
    // echo json_encode($testid);*/

    if ($response['status'] === true) {
        echo json_encode(new RequestCodeResult($response['ucaller_id'], true, ""));
    }

    //throw new Exception('Неизвестная ошибка');
}