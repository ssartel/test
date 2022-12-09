<?php

namespace System\Data;

use System\Contracts\ParseDataInterface;
use System\Exceptions\InvalidParamException;

class ParserSelector
{
    public static function getParser(string $name) : ParseDataInterface
    {
        switch ($name) {
            case "json" :
                return new JSON();
            case "xml" :
                return new XML();
            default :
                throw new InvalidParamException('wrong file type');
        }
    }
}