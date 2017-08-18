<?php

/*
 * Soluble Japha
 *
 * @link      https://github.com/belgattitude/soluble-japha
 * @copyright Copyright (c) 2013-2017 Vanvelthem Sébastien
 * @license   MIT License https://github.com/belgattitude/soluble-japha/blob/master/LICENSE.md
 */

namespace SolubleTest\Japha\Bridge;

use Soluble\Japha\Bridge\Adapter;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2014-11-04 at 16:47:42.
 */
class AdapterUsageUtilTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var string
     */
    protected $servlet_address;

    /**
     * @var Adapter
     */
    protected $adapter;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        \SolubleTestFactories::startJavaBridgeServer();

        $this->servlet_address = \SolubleTestFactories::getJavaBridgeServerAddress();

        $this->adapter = new Adapter([
            'driver' => 'Pjb62',
            'servlet_address' => $this->servlet_address,
        ]);
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }

    public function testHashSet()
    {
        $ba = $this->adapter;
        $set = $ba->java('java.util.HashSet');
        $elements = ['one', 'two', 'three'];
        foreach ($elements as $element) {
            $set->add($element);
        }
        $this->assertEquals(count($elements), $set->size());
        $this->assertTrue($set->contains('one'));
        $this->assertFalse($set->contains('four'));
    }

    public function testTreeSet()
    {
        $ba = $this->adapter;
        $set = $ba->java('java.util.HashSet');
        $numbers = [12, 34, 200, 8, 24];
        foreach ($numbers as $number) {
            $set->add($number);
        }
        $treeSet = $ba->java('java.util.TreeSet', $set);
        $this->assertEquals(8, $treeSet->first()->intValue());
        $this->assertEquals(200, $treeSet->last()->intValue());
    }

    public function testEnum()
    {
        $ba = $this->adapter;
        $formatStyle = $ba->javaClass('java.time.format.FormatStyle');

        $this->assertEquals('LONG', $formatStyle->LONG);
        $this->assertNotEquals('LONG', $formatStyle->SHORT);

        $availableStyles = $formatStyle->values();
        $styles = [];
        foreach ($availableStyles as $style) {
            $styles[] = (string) $style->toString();
        }
        $this->assertArraySubset(['FULL', 'LONG', 'MEDIUM', 'SHORT'], $styles);
    }

    public function testEnumSet()
    {
        $ba = $this->adapter;
        $formatStyle = $ba->javaClass('java.time.format.FormatStyle');

        $enumSet = $ba->javaClass('java.util.EnumSet');
        $set = $enumSet->of($formatStyle->LONG);
        $this->assertEquals('[LONG]', (string) $set->toString());

        $sets = $enumSet->of($formatStyle->LONG, $formatStyle->SHORT);
        $this->assertEquals('[LONG, SHORT]', (string) $sets->toString());
    }
}
