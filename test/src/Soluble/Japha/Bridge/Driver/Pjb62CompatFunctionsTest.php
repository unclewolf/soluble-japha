<?php

use Soluble\Japha\Bridge\Driver\Pjb62\PjbProxyClient;

//use Soluble\Japha\Bridge\Driver\Pjb62;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2014-11-04 at 16:47:42.
 */
class Pjb62CompatFunctionsTest extends \PHPUnit_Framework_TestCase
{
    /**
     *
     * @var string
     */
    protected $servlet_address;



    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->servlet_address = \SolubleTestFactories::getJavaBridgeServerAddress();
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }


    public function testCompatFunctions()
    {
        $pjb = PjbProxyClient::getInstance(array(
            'driver' => 'Pjb62',
            'servlet_address' => $this->servlet_address,
            'load_pjb_compatibility' => true
        ));


        $i1 = new Java("java.math.BigInteger", 1);
        $i2 = new Java("java.math.BigInteger", 2);


        $this->assertInstanceOf('Soluble\Japha\Bridge\Driver\Pjb62\Java', $i2);


        $i3 = $i1->add($i2);
        $this->assertInstanceOf('Soluble\Japha\Bridge\Driver\Pjb62\InternalJava', $i3);
        $this->assertTrue(java_instanceof($i1, java_class('java.math.BigInteger')));

        $this->assertTrue(java_instanceof($i3, 'java.math.BigInteger'));

        $this->assertEquals('3', $i3->toString());


        $params = java_class("java.util.HashMap");
        $this->assertInstanceOf('Soluble\Japha\Bridge\Driver\Pjb62\Java', $params);
        //$this->assertEquals('java.util.HashMap', $params->get__signature());


        $util = java_class("php.java.bridge.Util");

        $ctx = java_context();
        /* get the current instance of the JavaBridge, ServletConfig and Context */
        $bridge = $ctx->getAttribute("php.java.bridge.JavaBridge", 100);
        $config = $ctx->getAttribute("php.java.servlet.ServletConfig", 100);
        $context = $ctx->getAttribute("php.java.servlet.ServletContext", 100);
        $servlet = $ctx->getAttribute("php.java.servlet.Servlet", 100);


        $inspected = java_inspect($bridge);
        $this->assertInternalType('string', $inspected);
        $this->assertContains('php.java.bridge.JavaBridge.getCachedString', $inspected);
    }
}