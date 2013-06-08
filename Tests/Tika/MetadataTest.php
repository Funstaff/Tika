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
    public function testMetadataTextFormat()
    {
        $raw = file_get_contents(__DIR__.'/../File/metadata.txt');
        $meta = new Metadata($raw);
        $this->assertEquals($raw, $meta->getRaw());
        $this->assertEquals('text', $meta->getFormat());
    }

    public function testMetadataJsonFormat()
    {
        $raw = file_get_contents(__DIR__.'/../File/metadata.json');
        $meta = new Metadata($raw, 'json');
        $this->assertEquals('json', $meta->getFormat());
    }
}