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
     * Checks the addCount and getCounts method
     */
    public function testCountSetGet()
    {
        $data = new Phighchart\Data();
        $data->addCount('seo', 100);
        $data->addCount('ppc', 12);
        $this->assertSame($data->getCount('seo'), 100);
        $this->assertFalse($data->getCount('anotherKey'));
        $this->assertNotSame($data->getCount('ppc'), 13);
        $this->assertInternalType('array', $data->getCounts());
    }
}
