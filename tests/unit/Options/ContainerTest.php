<?php
/**
 * Tests for the Phighchart\Options\Container class
 */

namespace Phighchart\Test\Options;

use Phighchart\Options\Container;

class ContainerTest extends \PHPUnit_Framework_TestCase
{
    public function testGetOptionsType()
    {
        $options = new Container('optionsType');
        $this->assertSame('optionsType', $options->getOptionsType());
    }

    public function testSetGetOption()
    {
        $options = new Container('optionsType');
        $this->assertSame($options, $options->setOption('myKey', 'someValue'));
        $this->assertInstanceOf('StdClass', $options->getOptions());
        $this->assertSame('someValue', $options->getOptions()->myKey);
    }

    public function testMagicCalls()
    {
        $options = new Container('optionsType');
        $options->setRandomProperty(133);
        $this->assertSame($options, $options->setAnotherRandomProperty($stdClass = new \StdClass()));
        $this->assertSame(133, $options->getOptions()->randomProperty);
        $this->assertSame($stdClass, $options->getOptions()->anotherRandomProperty);
    }
}
