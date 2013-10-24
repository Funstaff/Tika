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

use Funstaff\Tika\Configuration;
use Funstaff\Tika\Document;
use Funstaff\Tika\Wrapper;

/**
 * WrapperTest
 *
 * @author Bertrand Zuchuat <bertrand.zuchuat@gmail.com>
 */
class WrapperTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $config = new Configuration(__DIR__.'/../../tika.jar');
        $this->wrapper = new Wrapper($config);
    }

    public function testConfiguration()
    {
        $this->assertInstanceOf('Funstaff\Tika\ConfigurationInterface', $this->wrapper->getConfiguration());
    }
    
    public function testSetParameter()
    {
        $this->wrapper->setParameter('outputFormat', 'html');
        $this->assertEquals('html', $this->wrapper->getConfiguration()->getOutputFormat());
    }

    public function testFailedSetParameter()
    {
        try {
            $this->wrapper->setParameter('Foo', 'Bar');
        } catch (\InvalidArgumentException $e) {
            return;
        }
        $this->fail('Invalid parameter on configuration');
    }

    public function testDocument()
    {
        $this->assertNull($this->wrapper->getDocument());
        $filePath = __DIR__.'/../File/test.pdf';
        $doc = new Document('test.pdf', $filePath);
        $this->wrapper->addDocument($doc);
        $this->assertInternalType('array', $this->wrapper->getDocument());
        $this->assertEquals(1, count($this->wrapper->getDocument()));
        $this->assertInstanceOf('Funstaff\Tika\Document', $this->wrapper->getDocument('test.pdf'));
        $doc = new Document('test2.pdf', $filePath);
        $this->wrapper->addDocument($doc);
        $this->assertEquals(2, count($this->wrapper->getDocument()));
    }

    public function testExecute()
    {
        $filePath = __DIR__.'/../File/test.pdf';
        $doc = new Document('test.pdf', $filePath);
        $this->wrapper->addDocument($doc);
        $this->wrapper->setParameter('outputFormat', 'xml')->execute();
        $document = $this->wrapper->getDocument('test.pdf');
        $this->assertInstanceOf('Funstaff\Tika\DocumentInterface', $document);
        $this->assertInstanceOf('Funstaff\Tika\MetadataInterface', $document->getMetadata());
    }

    public function testExecuteWithFileWithSpace()
    {
        $filePath = __DIR__.'/../File/test interview.pdf';
        $doc = new Document('test interview.pdf', $filePath);
        $this->wrapper->addDocument($doc);
        $this->wrapper->setParameter('outputFormat', 'xml')->execute();
        $document = $this->wrapper->getDocument('test interview.pdf');
        $this->assertEquals('test interview.pdf', $document->getName());
        $this->assertEquals('recruit', $document->getMetadata()->get('subject'));
    }

    public function testExecuteTextNoMetadataContent()
    {
        $filePath = __DIR__.'/../File/test.pdf';
        $doc = new Document('test.pdf', $filePath);
        $this->wrapper->addDocument($doc);
        $this->wrapper->setParameter('outputFormat', 'text')->execute();
        $document = $this->wrapper->getDocument('test.pdf');
        $this->assertNull($document->getMetadata());
    }
}