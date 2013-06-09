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

/**
 * ConfigurationTest
 *
 * @author Bertrand Zuchuat <bertrand.zuchuat@gmail.com>
 */
class ConfigurationTest extends \PHPUnit_Framework_TestCase
{
    protected $config;

    public function setUp()
    {
        $this->config = new Configuration(__DIR__.'/../../tika.jar');
    }

    public function testFailedTikaBinaryPath()
    {
        try {
            $config = new Configuration('/tika.jar');
        } catch (\InvalidArgumentException $e) {
            return;
        }
        $this->fail('Tika binary does not exists on this path.');
    }

    public function testFailedJavaBinaryPath()
    {
        try {
            new Configuration(__DIR__.'/../../tika.jar', '/java');
        } catch (\InvalidArgumentException $e) {
            return;
        }
        $this->fail('Java binary does not exists on this path.');
    }

    public function testTikaBinaryPath()
    {
        $this->assertEquals(__DIR__.'/../../tika.jar', $this->config->getTikaBinaryPath());
    }
    
    public function testJavaBinaryPath()
    {
        $this->assertNull($this->config->getJavaBinaryPath());
    }

    public function testMetadataClass()
    {
        $this->assertEquals('Funstaff\Tika\Metadata', $this->config->getMetadataClass());
        $this->config->setMetadataClass('Funstaff\Tika\MetaFoo');
        $this->assertEquals('Funstaff\Tika\MetaFoo', $this->config->getMetadataClass());
    }

    public function testOutputFormat()
    {
        $this->assertEquals('xml', $this->config->getOutputFormat());
        $this->config->setOutputFormat('text');
        $this->assertEquals('text', $this->config->getOutputFormat());
    }

    public function testFailedOutputFormat()
    {
        try {
            $this->config->setOutputFormat('foo');
        } catch (\InvalidArgumentException $e) {
            return;
        }
        $this->fail('Invalid Output format');
    }

    public function testMetadataOnly()
    {
        $this->assertFalse($this->config->getMetadataOnly());
        $this->config->setMetadataOnly(true);
        $this->assertTrue($this->config->getMetadataOnly());
    }

    public function testOutputEncoding()
    {
        $this->assertEquals('UTF-8', $this->config->getOutputEncoding());
        $this->config->setOutputEncoding('ISO-8859');
        $this->assertEquals('ISO-8859', $this->config->getOutputEncoding());
    }
}