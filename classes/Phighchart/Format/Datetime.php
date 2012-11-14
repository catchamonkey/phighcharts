<?php

namespace Phighchart\Format;

use Phighchart\Chart;
use Phighchart\PropertyType\Raw;
use Phighchart\Options\Container;
use Phighchart\Format\FormatInterface;

/**
 * Format for plotting chart labels for datetime type
 * @author Shahrukh Omar <shahrukhomar@gmail.com>
 */
class Datetime implements FormatInterface
{
    /**
     * Custom date format pattern
     * @var String
     */
    private $_format;

    public function __construct()
    {
        $this->_format = null;
    }

    /**
     * Set the custom date format if the given dates are not in
     * localized or ISO8601 standard notation
     * @throws InvalidArgumentException If given date time string format is invalid
     * @param  String                   $format date time format string
     */
    public function setDateTimeFormat($format)
    {
        $date = new \DateTime();
        $dateString = $date->format($format);

        if (\DateTime::createFromFormat($format, $dateString)) {
            $this->_format = $format;
        } else {
            throw new \InvalidArgumentException(
                'The given date time string format is not valid'
            );
        }
    }

    /**
     * Sets the xAxis type as datetime and returns it in a Phighchart\Container
     * @param  Chart                $chart chart instance
     * @return Phighchart\Container
     */
    public function getFormatOptions(Chart $chart)
    {
        $xAxis = $chart->getOptionsType('xAxis', new Container('xAxis'));
        $xAxis->setType('datetime');

        return $xAxis;
    }

    /**
     * Returns the plottable chart data formatter as js Date
     * @param  Array $seriesData Series data as supplied by the user
     * @return Array
     */
    public function getFormattedChartData(Array $seriesData)
    {
        $ret = array();
        foreach ($seriesData as $date => $value) {
            //render the js Date obect as raw
            $ret[] = Raw::encode(
                '['.$this->_convertStringToJsDate($date).','.$value.']');
        }

        return $ret;
    }

    /**
     * Converts a datetime string to JS Datetime object. Accepts standard
     * PHP localized date time notation and ISO8601 standard notation
     * OR custom datetime string format when the formatting pattern is supplied
     * @link   http://no2.php.net/manual/en/datetime.formats.compound.php
     * @link   http://no2.php.net/manual/en/datetime.formats.date.php
     * @throws InvalidArgumentException If string format cannot be parsed
     * @param  String                   $stringDate Datetime string to convert
     * @return String
     */
    private function _convertStringToJsDate($stringDate)
    {
        $date = false;
        //if custom date format has been defined by the user, use it to
        //translate date string into PHP DateTime object
        if (
            !is_null($this->_format) &&
            !$date = \DateTime::createFromFormat($this->_format, $stringDate)
        ) {
            throw new \InvalidArgumentException(
                sprintf(
                    "Could not parse date '%s' using the given date format "
                    . "'%s'", $stringDate, $this->_format
                )
            );
        }

        //attempt to parse the string into PHP DateTime object if it hasn't
        //been parsed using the custom format
        if (!$date instanceof \DateTime) {
            $date = new \DateTime($stringDate);
        }

        $exploded = explode('.', $date->format('Y.m.d.H.i.s'));

        //JS Date object month starts from 0
        if (isset($exploded[1]) && $exploded[1] > 0) {
            $exploded[1] -= 1;
        }

        return 'Date.UTC('.implode(',', $exploded).')';
    }
}
