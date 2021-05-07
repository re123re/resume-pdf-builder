<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/data_access/models/User.php';

class UserLoginService
{
    /**
     * Получить признак наличия действующей подписки.
     *
     * @param int $phone_number
     * @return bool
     * @throws Exception
     */
    public function hasActiveSubscription(int $phone_number): bool
    {
        $config = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . '/config.ini');
        $db = new mysqli($config['host'], $config['username'], $config['password'], $config['database']);
        if (!$db) {
            throw new Exception('Ошибка соединения: ' . mysqli_connect_error());
        }

        $tableName = User::DB_ENTITY;
        $result = $db->query(<<<EOF
SELECT 1
FROM `{$tableName}`
WHERE `phone_number` = {$phone_number} AND CURDATE() < `valid_until`
EOF
        );

        return $result->num_rows > 0;
    }

    /**
     * Активировать подписку на 14 дней.
     * Если пользователь уже регистрировался, то информация о подписке обновляется,
     * в противном случае создается новая запись.
     *
     * @param int $phone_number
     */
    public function activateSubscription(int $phone_number): void
    {
        $config = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . '/config.ini');
        $db = new mysqli($config['host'], $config['username'], $config['password'], $config['database']);
        if (!$db) {
            throw new Exception('Ошибка соединения: ' . mysqli_connect_error());
        }

        $tableName = User::DB_ENTITY;

        $hasUserQueryResult = $db->query(<<<EOF
SELECT 1
FROM {$tableName}
WHERE `phone_number` = {$phone_number}
EOF);
        if ($hasUserQueryResult->num_rows > 0) {
            $db->query(<<<EOF
UPDATE {$tableName}
SET `valid_until` = DATE_ADD(CURDATE(), INTERVAL 14 DAY)
WHERE `phone_number` = {$phone_number}
EOF);
        } else {
            $db->query(<<<EOF
INSERT INTO {$tableName} (`phone_number`, `valid_until`) 
VALUES({$phone_number}, DATE_ADD(CURDATE(), INTERVAL 14 DAY))
EOF);
        }
    }

    /**
     * Получить признак регистрации пользователя.
     * Если пользователь зарегистрирован, то значит он уже оплатил подписку хотя бы 1 раз,
     * так как регистрация возможна только после приобретения подписки.
     *
     * @param int $phone_number
     * @return bool
     * @throws Exception
     */
    public function isRegistered(int $phone_number): bool
    {
        $config = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . '/config.ini');
        $db = new mysqli($config['host'], $config['username'], $config['password'], $config['database']);
        if (!$db) {
            throw new Exception('Ошибка соединения: ' . mysqli_connect_error());
        }

        $tableName = User::DB_ENTITY;
        $result = $db->query(<<<EOF
SELECT 1
FROM `{$tableName}`
WHERE `phone_number` = {$phone_number}
EOF
        );

        return $result->num_rows > 0;
    }
}