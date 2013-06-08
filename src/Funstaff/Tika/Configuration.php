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
    protected $outputMetadataFormat = 'json';
    protected $outputEncoding = 'UTF8';

    public function __construct($tikaPath)
    {
        $this->tikaPath = $tikaPath;
    }

    function getTikaBinaryPath()
    {
        return $this->tikaPath;
    }

    function setOutputFormat($format)
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

    function getOutputFormat()
    {
        return $this->outputFormat;
    }

    function setOutputMetadataFormat($format)
    {
        $output = array('json', 'xmp');
        if (!in_array($format, $output)) {
            throw new \InvalidArgumentException(sprintf(
                'Available output Metadata format: %s',
                implode(', ', $output)
            ));
        }
        $this->outputMetadataFormat = $format;

        return $this;
    }

    function getOutputMetadataFormat()
    {
        return $this->outputMetadataFormat;
    }

    function setOutputEncoding($encoding)
    {
        $this->outputEncoding = $encoding;

        return $this;
    }

    function getOutputEncoding()
    {
        return $this->outputEncoding;
    }
}