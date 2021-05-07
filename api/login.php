<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/data_access/security/UserLoginService.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/data_access/models/LoginResult.php';

login();

function login()
{
    header("Content-type: application/json; charset=utf-8");

    $ucaller_id = $_POST["ucaller_id"];
    $phone_number = $_POST["phone_number"];
    $code = $_POST["code"];

    $userLoginService = new UserLoginService();

    if ((is_null($phone_number) || $phone_number === ""))
    {
        echo json_encode(new LoginResult("", false, 'Не указан номер телефона'));
        return;
    }

    if ((is_null($code) || $code === ""))
    {
        echo json_encode(new LoginResult("", false, 'Не указан проверочный код'));
        return;
    }

    if (!checkPhoneCodeValid($ucaller_id, $code))
    {
        echo json_encode(new LoginResult("", false, 'Неверно введен проверочный код'));
        return;
    }

    $result = $userLoginService->hasActiveSubscription($phone_number);
    if ($result)
    {
        // TODO: Реализовать генерацию и хранение токенов для поддержки сессий
        // Ниже установка куки - временное крайне небезопасное решение
        setcookie("Authorized", "true", time() + 3600 * 24 * 14, "/");
        echo json_encode(new LoginResult("", true, ""));
    }
    else
    {
        echo json_encode(new LoginResult("", false, 'Подписка не активна'));
    }
}

function checkPhoneCodeValid(int $ucaller_id, string $code) : bool
{
    $config = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . '/config.ini');
    $service_id = $config['service_id'];
    $secret_key = $config['private_key'];

    $request = file_get_contents('https://api.ucaller.ru/v1.0/getInfo?service_id='.$service_id.'&key='.$secret_key.'&uid='.$ucaller_id);
    $response = json_decode($request, true);

    if ($response['status'] === true)
    {
        if ($response['code'] === $code)
        {
            return true;
        }
    }

    return false;
}