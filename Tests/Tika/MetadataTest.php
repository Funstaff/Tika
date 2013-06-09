<?php

/*
 * This file is part of the Tika package.
 *
 * (c) Bertrand Zuchuat <bertrand.zuchuat@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Funstaff\Tika\Tests;

use Funstaff\Tika\Metadata;

/**
 * MetadataTest
 *
 * @author Bertrand Zuchuat <bertrand.zuchuat@gmail.com>
 */
class MetadataTest extends \PHPUnit_Framework_TestCase
{
    public function testMetadata()
    {
        $json = json_decode(file_get_contents(__DIR__.'/../File/metadata.json'));
        $meta = new Metadata();
        $this->assertInternalType('array', $meta->getAll());
        $this->assertEquals(0, count($meta->getAll()));
        $meta->add('author', $json->{'Author'});
        $this->assertEquals(1, count($meta->getAll()));
        $this->assertEquals('People', $meta->get('author'));
        $meta->add('title', $json->{'dc:title'});
        $this->assertEquals(2, count($meta->getAll()));
        $this->assertEquals('Test pdf', $meta->get('title'));
    }

    public function testFailedMetadata()
    {
        $json = json_decode(file_get_contents(__DIR__.'/../File/metadata.json'));
        $meta = new Metadata();
        try {
            $meta->get('Foo');
        } catch (\InvalidArgumentException $e) {
            return;
        }
        $this->fail('The Foo key does not exists on data array');
    }
}