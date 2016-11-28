<?php

namespace SolubleTest\Japha\Bridge;

use Soluble\Japha\Bridge\Adapter;
use Soluble\Japha\Bridge\Driver\ClientInterface;
use Soluble\Japha\Bridge\Driver\DriverInterface;
use Soluble\Japha\Bridge\Exception\JavaException;
use Soluble\Japha\Interfaces\JavaObject;

class DriverContextServletTest extends \PHPUnit_Framework_TestCase
{
    /**
     *
     * @var string
     */
    protected $servlet_address;

    /**
     *
     * @var Adapter
     */
    protected $adapter;

    /**
     * @var DriverInterface
     */
    protected $driver;

    protected function setUp()
    {
        \SolubleTestFactories::startJavaBridgeServer();
        $this->servlet_address = \SolubleTestFactories::getJavaBridgeServerAddress();
        $this->adapter = new Adapter([
            'driver' => 'Pjb62',
            'servlet_address' => $this->servlet_address,
        ]);
        $this->driver = $this->adapter->getDriver();
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }


    public function testGetServlet()
    {
        $context = $this->driver->getJavaContext();

        try {
            $servletContext = $context->getServlet();
        } catch (JavaException $e) {
            $msg = $e->getMessage();
            if ($e->getJavaClassName() == 'java.lang.IllegalStateException' &&
                preg_match('/PHP not running in a servlet environment/', $msg)) {

                // Basically mark this test as skipped as the test
                // was made on the standalone server
                $this->markTestIncomplete('Retrieval of servlet context is not supported with the standalone server');
                return;
            } else {
                throw $e;
            }
        }
        $this->assertInstanceOf(JavaObject::class, $servletContext);
    }
}
