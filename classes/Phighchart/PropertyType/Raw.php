<?php

namespace Phighchart\PropertyType;

/**
 * Use the Type/Raw to mark the highchart properties that need to be rendered
 * as they are and not to be rendered as string e.g. function callbacks,
 * JS object types etc.
 * @author Shahrukh Omar <shahrukhomar@gmail.com>
 */

class Raw
{
    const TYPE_RAW_DELIMITER = "~~";

    /**
     * Adds the raw delimiter to the given subject string
     * @param  String $subject string to be rendered as raw
     * @return String
     */
    public static function encode($subject)
    {
        return self::TYPE_RAW_DELIMITER.$subject.self::TYPE_RAW_DELIMITER;
    }

    /**
     * Removes the raw delimiter from the given subject string
     * @param  String $subject string to be decoded
     * @return String
     */
    public static function decode($subject)
    {
        $patterns = array(
            "/\"".self::TYPE_RAW_DELIMITER."/",
            "/".self::TYPE_RAW_DELIMITER."\"/",
            "/".self::TYPE_RAW_DELIMITER."/"
        );

        return preg_replace($patterns, '', $subject);
    }
}