<?php
/**
 * Tests for the Phighchart\Options\Container class
 */

namespace Phighchart\Test\Options;

use Phighchart\Options\ExtendedContainer;

class ExtendedContainerTest extends \PHPUnit_Framework_TestCase
{
    public function testStickyColours()
    {
        $options = new ExtendedContainer();
        $options->setStickyColour('apples', '#629632');
        $this->assertSame('#629632', $options->getStickyColour('apples'));
        // case insensitive match test
        $this->assertSame('#629632', $options->getStickyColour('APPLES'));
    }
}
