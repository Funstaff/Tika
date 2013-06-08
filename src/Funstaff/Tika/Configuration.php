<?php

/*
 * This file is part of the Tika package.
 *
 * (c) Bertrand Zuchuat <bertrand.zuchuat@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Funstaff\Tika;

/**
 * Configuration
 *
 * @author Bertrand Zuchuat <bertrand.zuchuat@gmail.com>
 */
class Configuration implements ConfigurationInterface
{
    protected $tikaPath;
    protected $outputFormat = 'xml';
    protected $outputMetadataFormat = 'text';
    protected $outputEncoding = 'UTF8';
    protected $metadataOnly = false;

    public function __construct($tikaPath)
    {
        $this->tikaPath = $tikaPath;
        if (!file_exists($tikaPath)) {
            throw new \InvalidArgumentException(
                'The Tika binary does not exists.'
            );
        }
    }

    public function getTikaBinaryPath()
    {
        return $this->tikaPath;
    }

    public function setOutputFormat($format)
    {
        $output = array('xml', 'html', 'text', 'text-main');
        if (!in_array($format, $output)) {
            throw new \InvalidArgumentException(sprintf(
                'Available output format: %s',
                implode(', ', $output)
            ));
        }
        $this->outputFormat = $format;

        return $this;
    }

    public function getOutputFormat()
    {
        return $this->outputFormat;
    }

    public function setMetadataOnly($metadata = false)
    {
        $this->metadataOnly = (bool) $metadata;

        return $this;
    }

    public function getMetadataOnly()
    {
        return $this->metadataOnly;
    }

    public function setOutputMetadataFormat($format)
    {
        $output = array('text', 'json', 'xmp');
        if (!in_array($format, $output)) {
            throw new \InvalidArgumentException(sprintf(
                'Available output Metadata format: %s',
                implode(', ', $output)
            ));
        }
        $this->outputMetadataFormat = $format;

        return $this;
    }

    public function getOutputMetadataFormat()
    {
        return $this->outputMetadataFormat;
    }

    public function setOutputEncoding($encoding)
    {
        $this->outputEncoding = $encoding;

        return $this;
    }

    public function getOutputEncoding()
    {
        return $this->outputEncoding;
    }
}