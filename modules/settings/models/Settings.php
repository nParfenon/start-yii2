<?php

namespace app\modules\settings\models;

use ParseCsv\Csv;

class Settings
{

    const _PATH = '../modules/settings/database/';
    const _DELIMITER = ';';

    /*
    * ['name' => ['value'],'description' => ['value', 'label']]
    */
    public static function getValue(array $field): array
    {
        $csv = new Csv();
        $csv->delimiter = self::_DELIMITER;
        $csv->parseFile(self::_PATH . 'setting.csv');

        $data = $csv->data;

        foreach ($data as $item) {

            if (array_key_exists($item['field'], $field) === true) {

                foreach ($field[$item['field']] as $f) $result[$item['field']][$f] = $item[$f];

            }

        }

        return $result;
    }
}
