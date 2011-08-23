<?php
/**
 * Tests for the Phighchart\Data class
 */
require_once '/home/sites/phighcharts/poc/UniversalClassLoader.php';
use Symfony\Component\ClassLoader\UniversalClassLoader;
class DataTest extends PHPUnit_Framework_TestCase
{

    private $_loader;

    public function setUp()
    {

        $this->loader = new UniversalClassLoader();
        $this->loader->register();

        $this->loader->registerNamespaces(array(
            'Phighchart' => __DIR__.'/../../classes'
        ));
    }

    /**
     * Checks the addCount, getCount and getCounts method
     */
    public function testCountSetGet()
    {
        $data = new Phighchart\Data();
        $data->addCount('seo', 100);
        $data->addCount('ppc', 12);
        $this->assertSame(100, $data->getCount('seo'));
        $this->assertFalse($data->getCount('iDontExist'));
        $this->assertNotSame(13, $data->getCount('ppc'));
        $this->assertInternalType('array', $data->getCounts());
        $this->assertInternalType('integer', $data->getCount('ppc'));
    }
}
