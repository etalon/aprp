<?php

class StringExtensions {

    public static function StartsWith($haystack, $needle)
    {

        $len = strlen($needle);

        if (strlen($haystack) < $needle) {
            return false;
        }

        return substr($haystack, 0, $len) === $needle;

    }

    public static function EndsWith($haystack, $needle)
    {
        $len = strlen($needle);

        if (strlen($haystack) < $needle) {
            return false;
        }

        return substr($haystack, strlen($haystack) - $len) === $needle;

    }

}