<?php

class Hash
{
    public static function make($string)
    {
        return hash('md5', $string);
    }

}