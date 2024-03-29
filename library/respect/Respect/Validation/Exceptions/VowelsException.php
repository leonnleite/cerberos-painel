<?php

namespace Respect\Validation\Exceptions;

class VowelsException extends AlphaException
{

    public static $defaultTemplates = array(
        self::MODE_DEFAULT => array(
            self::STANDARD => '{{name}} must contain only vowels',
            self::EXTRA => '{{name}} must contain only vowels and "{{additionalChars}}"'
        ),
        self::MODE_NEGATIVE => array(
            self::STANDARD => '{{name}} must not contain vowels',
            self::EXTRA => '{{name}} must not contain vowels or "{{additionalChars}}"'
        )
    );

}
