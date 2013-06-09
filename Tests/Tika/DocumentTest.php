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

use Funstaff\Tika\Document;
use Funstaff\Tika\Metadata;

/**
 * DocumentTest
 *
 * @author Bertrand Zuchuat <bertrand.zuchuat@gmail.com>
 */
class DocumentTest extends \PHPUnit_Framework_TestCase
{
    public function testFailedDocument()
    {
        try {
            $doc = new Document('Foo', 'bar.pdf');
        } catch (\InvalidArgumentException $e) {
            return;
        }
        $this->fail('Document does not exists');
    }
    
    public function testDocument()
    {
        $filePath = __DIR__.'/../File/test.pdf';
        $doc = new Document('test.pdf', $filePath);
        $this->assertEquals('test.pdf', $doc->getName());
        $this->assertEquals($filePath, $doc->getPath());
        $this->assertNull($doc->getPassword());
    }
    
    public function testPassword()
    {
        $filePath = __DIR__.'/../File/test.pdf';
        $doc = new Document('test.pdf', $filePath, '123456');
        $this->assertEquals('123456', $doc->getPassword());
    }

    public function testMetadata()
    {
        $doc = new Document('test.pdf', __DIR__.'/../File/test.pdf');
        $this->assertNull($doc->getMetadata());
        $metadata = new Metadata('Foo');
        $doc->setMetadata($metadata);
        $this->assertInstanceOf('Funstaff\Tika\MetadataInterface', $doc->getMetadata());
    }

    public function testContent()
    {
        $doc = new Document('test.pdf', __DIR__.'/../File/test.pdf');
        $this->assertNull($doc->getContent());
        $doc->setContent('Foo - Bar');
        $this->assertEquals('Foo - Bar', $doc->getContent());
    }
    
    public function testRawContent()
    {
        $doc = new Document('test.pdf', __DIR__.'/../File/test.pdf');
        $doc->setRawContent('Bar');
        $this->assertEquals('Bar', $doc->getRawContent());
    }
}