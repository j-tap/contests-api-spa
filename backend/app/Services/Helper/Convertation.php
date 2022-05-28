<?php

namespace App\Services\Helper;

class Convertation
{
    private const SPECIAL_SYMBOLS_REGEX = '/[#@$%^&*()+=\-\[\]\';,.\/{}|":<>?~\\\\]/i';
    private const LETTERS = [
        'cyrilic' => ['Љ','Њ','Џ','џ','ш','ђ','ч','ћ','ж','љ','њ','Ш','Ђ','Ч','Ћ','Ж','Ц','ц','а','б','в','г','д','е','ё','ж','з','и','й','к','л','м','н','о','п','р','с','т','у','ф','х','ц','ч','ш','щ','ъ','ы','ь','э','ю','я','А','Б','В','Г','Д','Е','Ё','Ж','З','И','Й','К','Л','М','Н','О','П','Р','С','Т','У','Ф','Х','Ц','Ч','Ш','Щ','Ъ','Ы','Ь','Э','Ю','Я'],
        'latin' => ['Lj','Nj','Dž','dž','š','đ','č','ć','ž','lj','nj','Š','Đ','Č','Ć','Ž','C','c','a','b','v','g','d','e','io','zh','z','i','y','k','l','m','n','o','p','r','s','t','u','f','h','ts','ch','sh','sht','a','i','y','e','yu','ya','A','B','V','G','D','E','Io','Zh','Z','I','Y','K','L','M','N','O','P','R','S','T','U','F','H','Ts','Ch','Sh','Sht','A','I','Y','e','Yu','Ya'],
    ];

    /**
     * Преобразование объекта в строку вида: `key:value, ...`
     *
     * @param  array $array
     * @return string
     */
    public static function objectToString (array $array): string
    {
        array_walk($array, function(&$val, $key) {
            $val = "{$key}:{$val}";
        });
        return implode($array);
    }

    /**
     * Преобразование букв строки в латиницу
     *
     * @param  string $value
     * @return string
     */
    public static function stringToLatin (string $value): string
    {
        return str_replace(self::LETTERS['cyrilic'], self::LETTERS['latin'], $value);
    }

    /**
     * Преобразование букв строки в кирилицу
     *
     * @param  string $value
     * @return string
     */
    public static function stringToCyrilic (string $value): string
    {
        return str_replace(self::LETTERS['latin'], self::LETTERS['cyrilic'], $value);
    }

    /**
     * Преобразование строки в формат snake_case
     *
     * @param  string $value
     * @return string
     */
    public static function stringToSnakeCase (string $value): string
    {
        $result = strtolower($value);
        $result = str_replace(' ', '_', $result);
        $result = preg_replace(self::SPECIAL_SYMBOLS_REGEX, '_', $result);
        $result = self::stringToLatin($result);
        return $result;
    }

}
