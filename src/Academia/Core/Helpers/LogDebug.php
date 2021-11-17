<?php

namespace Academia\Core\Helpers;

class LogDebug
{
    private static $path = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'Logs' . DIRECTORY_SEPARATOR . 'LogDebug.txt';

    public static function log($text): void
    {
        $now = new \DateTime('now', new \DateTimeZone("UTC"));
        $file = fopen(self::$path, "a");
        fwrite($file, $now->format('Y-m-d H:i:s.u :').self::convertObjectOrArrayToText($text).PHP_EOL);
        fclose($file);
        unset($now);
    }

    private static function convertObjectOrArrayToText($value): string
    {
        ob_start();
        if (is_object($value)) {
            var_dump($value);
        }
        else if (is_array($value)) {
            print_r($value);
        }
        else if (is_bool($value)) {
            if ($value) {
                echo "true";
            }
            else {
                echo "false";
            }
        }
        else {
            echo $value;
        }
        $text = ob_get_contents();
        ob_end_clean();
        return $text;
    }
}