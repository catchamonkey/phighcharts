<?php

namespace Phighchart\Test\PropertyType;

use Phighchart\PropertyType\Raw;

/**
 * Raw property type test
 * @author  Shahrukh Omar <sharhukhomar@gmail.com>
 */

class RawTest extends \PHPUnit_Framework_TestCase
{
    public function testRawEncode()
    {
        $testString = 'foo';
        $delimiter  = Raw::TYPE_RAW_DELIMITER;
        $expected   = $delimiter.$testString.$delimiter;

        $this->assertEquals($expected, Raw::encode($testString));
    }

    public function testRawDecode()
    {
        $testString = 'foo';
        $delimiter  = Raw::TYPE_RAW_DELIMITER;
        $encoded    = $delimiter.$testString.$delimiter;

        $this->assertEquals($testString, Raw::decode($encoded));
    }

    public function testRawRender()
    {
        $testData = array('foo' => Raw::encode('bar'));

        //expect the property 'bar' to be rendered as raw string and not wrapped
        //in the JSON standard quotes after being JSON encoded
        $expected = '{"foo":bar}';

        $this->assertEquals($expected, Raw::decode(json_encode($testData)));
    }
}