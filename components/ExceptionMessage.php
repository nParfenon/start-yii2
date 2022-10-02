<?php

namespace app\components;

class ExceptionMessage
{

    private static $error = [
        "404" => 'Страница не найдена.',
        "404_t2" => 'Запрашиваемая страница не существует.'
    ];

    public static function call($code)
    {
        return self::$error[$code];
    }

}