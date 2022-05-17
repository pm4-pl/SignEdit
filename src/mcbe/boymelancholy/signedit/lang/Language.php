<?php
/**
 *
 *  _____ _         _____   _ _ _
 * |   __|_|___ ___|   __|_| |_| |_
 * |__   | | . |   |   __| . | |  _|
 * |_____|_|_  |_|_|_____|___|_|_|
 *         |___|
 *
 * Sign editor for PocketMine-MP
 *
 * @author boymelancholy
 * @link https://github.com/boymelancholy/SignEdit/
 *
 */
declare(strict_types=1);

namespace mcbe\boymelancholy\signedit\lang;

class Language
{
    /** @var string[] */
    private static array $langTexts;

    public static function load(array $langTexts)
    {
        self::$langTexts = $langTexts;
    }

    /**
     * @param string $key
     * @param string[]|null $replace
     * @return string
     */
    public static function get(string $key, ?array $replace = null) : string
    {
        if (!isset(self::$langTexts[$key])) return $key;
        $raw = self::$langTexts[$key];
        if ($replace !== null) {
            for ($i = 0; $i < count($replace); ++$i) {
                $raw = str_replace("{%" . $i . "}", $replace[$i], $raw);
            }
        }
        return $raw;
    }
}