<?php

namespace Tests\Sample\Library1;

/**
 * Display the text with a red background and white foreground
 * and end it with the newline character (if desired)
 */
class Display
{
    /**
     * @param $text
     * @param bool $newline
     */
    public static function echo(string $text, $newline = true)
    {
        $color = "\e[0;57m";
        self::displayText($text, $color, $newline);
    }

    /**
     * @param $text
     * @param bool $newline
     */
    public static function success(string $text, bool $newline = true)
    {
        $color = "\e[0;32m";
        self::displayText($text, $color, $newline);
    }

    /**
     * @param $text
     * @param bool $newline
     */
    public static function info(string $text, bool $newline = true)
    {
        $color = "\e[0;34m";
        self::displayText($text, $color, $newline);
    }

    /**
     * @param string $text
     * @param bool $newline
     */
    public static function warning(string $text, bool $newline = true)
    {
        $color = "\e[0;33m";
        self::displayText($text, $color, $newline);
    }

    /**
     * @param $text
     * @param bool $newline
     *
     */
    public static function error(string $text, bool $newline = true)
    {
        $color = "\e[0;31m";
        self::displayText($text, $color, $newline);
    }

    /**
     * @param $text
     *
     */
    public static function exit(string $text)
    {
        die($text);
    }

    private static function addNewLine(string $text): string
    {
        $newLine = "\r\n";
        return $text . $newLine;
    }

    /**
     * @param string $text
     * @param string $color
     * @param bool $newline
     */
    protected static function displayText(string $text, string $color, bool $newline): void
    {
        //$reset = '\e[0m';
        $msg = $color . $text;
        echo $newline ? static::addNewLine($msg) : $text;
        echo  "\e[0;57m";;
    }
}
