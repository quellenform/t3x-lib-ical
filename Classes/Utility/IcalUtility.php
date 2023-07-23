<?php

declare(strict_types=1);

namespace Quellenform\LibIcal\Utility;

/*
 * This file is part of the "lib_ical" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use \DateTime;

/**
 * Class IcalUtility
 */
class IcalUtility
{
    private const CRLF = "\r\n";

    /**
     * Transforms a timestamp to an iCal compatible format.
     *
     * @param DateTime $datetime
     * @param bool $utc
     *
     * @return string
     */
    public static function dateToCal(DateTime $datetime, $utc = false): string
    {
        if ($utc) {
            return $datetime->format('Ymd\THis\Z');
        } else {
            return $datetime->format('Ymd\THis');
        }
    }

    /**
     * Escape the given string.
     *
     * @param string $string
     *
     * @return string
     */
    public static function escapeString(string $string): string
    {
        return preg_replace('/([\,;])/', '\\\$1', $string);
    }

    /**
     * Strip HTML from the given string
     *
     * @param string $string
     *
     * @return string
     */
    public static function stripHtml(string $string)
    {
        return strip_tags($string);
    }

    /**
     * Get formatted value.
     *
     * @param string $key The key name
     * @param string $value The value
     * @param array $params Additional parameters as multidimensional array
     *
     * @return string
     */
    public static function setProperty(string $key, string $value, array $params = []): string
    {
        if (!empty($value)) {
            // Prepend value with property name and additional parameters
            $value = strtoupper($key) . self::implodeParams($params) . ':' . $value . self::CRLF;
            // Return result, broken into lines with maximal 75 chars
            return implode(self::CRLF . ' ', str_split($value, 75));
        } else {
            return '';
        }
    }

    /**
     * Wrap item.
     *
     * @param string $key
     * @param mixed $value
     *
     * @return string
     */
    public static function wrapItem(string $key, mixed $value): string
    {
        if (!empty($value)) {
            if (is_array($value)) {
                $value = implode(self::CRLF, $value);
            }
            return 'BEGIN:' . strtoupper($key) . self::CRLF . $value . 'END:' . strtoupper($key) . self::CRLF;
        } else {
            return '';
        }
    }

    /**
     * Implode parameters.
     *
     * @param array $params
     *
     * @return string
     */
    public static function implodeParams(array $params = []): string
    {
        if (count($params)) {
            $parameters = [];
            foreach ($params as $paramKey => $paramValue) {
                $parameters[] = strtoupper($paramKey) . '=' . $paramValue;
            }
            return ';' . implode(';', $parameters);
        } else {
            return '';
        }
    }
}
