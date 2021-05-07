<?php

/**
 * Зарегистрированный пользователь
 */
class User
{
    const DB_ENTITY = 'users';

    /**
     * @var int Уникальный идентификатор
     */
    public int $id;

    /**
     * @var int Номер телефона (с кодом)
     */
    public int $phone;

    /**
     * @var string Дата, по которую действует подписка
     */
    public string $valid_until;
}

?>