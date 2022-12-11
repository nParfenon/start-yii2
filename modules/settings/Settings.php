<?php

namespace app\modules\settings;

use ParseCsv\Csv;

class Settings
{

    const _PATH = '../modules/settings/database/';
    const _FILE = 'settings.csv';
    const _DELIMITER = ';';

    public static function getValue(string $field)
    {
        $csv = new Csv();
        $csv->delimiter = self::_DELIMITER;
        $csv->parseFile(self::_PATH . self::_FILE);

        $data = $csv->data;

        foreach ($data as $item) {

            if ($item['field'] == $field) return $item['value'];

        }

        return false;
    }
}
