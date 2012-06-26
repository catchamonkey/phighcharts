<?php

namespace Phighchart\Options;

/**
 * Container for Phighchart Options section
 * There will generally be multiple instances of this Container passed into
 * a single Chart
 * @author Chris Sedlmayr catchamonkey <chris@sedlmayr.co.uk>
 */
class Container
{
    /**
     * The type of options being created (a section within highcharts options)
     */
    private $_optionsType;
    private $_options;

    public function __construct($optionsType = null)
    {
        $this->_optionsType     = $optionsType;
        $this->_options         = new \StdClass();
    }

    /**
     * Sets the options type for this instance of the options container
     * @param string $optionsType type of options
     */
    public function setOptionsType($optionsType)
    {
        $this->_optionsType = $optionsType;
    }

    /**
     * Returns the type of options you are defining
     */
    public function getOptionsType()
    {
        return $this->_optionsType;
    }

    /**
     * This function is designed to catch setter function calls
     * (methods starting with set), and uses the function name as the key you
     * are setting, e.g. setMargin(10) becomes margin:10
     * @param String $name      the name of the method being called.
     * @param Array  $arguments an enumerated array containing the parameters
     * passed to the $name'ed method.
     * @return Container $this Current instance
     */
    public function __call($name, Array $arguments)
    {
        // if the call starts with set, it is an option setting call so extract
        // the remaining part as the key
        if (substr($name, 0, 3) == 'set') {
            $key = lcfirst(substr($name, 3));
            $this->setOption($key, $arguments[0]);

            return $this;
        }
    }

    /**
     * Adds a single option
     * @param  String    $key   The key to store the option under
     * @param  String    $value The option value to store
     * @return Container $this Current instance
     **/
    public function setOption($key, $value)
    {
        $this->_options->$key = $value;

        return $this;
    }

    /**
     * Returns a single option by key
     * @param  String $key The key of the option you want to retrieve
     * @return Mixed, $ret option value if present, or $default if not (Default:FALSE)
     */
    public function getOption($key, $default = FALSE)
    {
        $ret = $default;
        if (isset($this->_options->$key)) {
            $ret = $this->_options->$key;
        }

        return $ret;
    }

    public function getOptions()
    {
        return $this->_options;
    }
}
