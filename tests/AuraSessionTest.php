<?php

/**
 * This file is part of phpab/phpab. (https://github.com/phpab/phpab)
 *
 * @link https://github.com/phpab/phpab for the canonical source repository
 * @copyright Copyright (c) 2015-2016 phpab. (https://github.com/phpab/)
 * @license https://raw.githubusercontent.com/phpab/phpab/master/LICENSE.md MIT
 */

namespace PhpAb\Storage\Adapter;

class AuraSessionTest extends \PHPUnit_Framework_TestCase
{

    public function setUp()
    {

        parent::setUp();
    }

    public function testHas()
    {
        // Arrange
        $auraSession = new AuraSession();
        $auraSession->set('foo', 'bar');

        // Act
        $resultFoo = $auraSession->has('foo');
        $resultBaz = $auraSession->has('baz');

        // Assert
        $this->assertTrue($resultFoo);
        $this->assertFalse($resultBaz);
    }

    public function testSet()
    {
        // Arrange
        $auraSession = new AuraSession();
        $auraSession->set('foo', []);
        $auraSession->set('baz', [1, 2, 3]);

        // Act
        $resultFoo = $auraSession->get('foo');
        $resultBaz = $auraSession->get('baz');

        // Assert
        $this->assertSame([], $resultFoo);
        $this->assertSame([1, 2, 3], $resultBaz);
    }

    public function testRemove()
    {
        // Arrange
        $auraSession = new AuraSession();
        $auraSession->set('foo', 'dub');
        $auraSession->set('baz', 'dim');

        // Act
        $resultRemove = $auraSession->remove('foo');
        $resultAll = $auraSession->all();


        // Assert
        $this->assertSame('dub', $resultRemove);
        $this->assertSame(
            [
                'baz' => 'dim'
            ],
            $resultAll
        );
    }

    public function testAll()
    {
        // Arrange
        $auraSession = new AuraSession();
        $auraSession->set('foo', []);
        $auraSession->set('baz', [1, 2, 3]);

        // Act
        $result = $auraSession->all();


        // Assert
        $this->assertEquals(
            [
                'foo' => [],
                'baz' => [1, 2, 3]
            ],
            $result
        );
    }

    public function testClear()
    {
        // Arrange
        $auraSession = new AuraSession();
        $auraSession->set('foo', []);
        $auraSession->set('baz', [1, 2, 3]);

        // Act
        $result = $auraSession->clear();


        // Assert
        $this->assertEquals(
            [
                'foo' => [],
                'baz' => [1, 2, 3]
            ],
            $result
        );
    }
}
