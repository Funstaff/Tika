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
    protected $javaPath;
    protected $metadataClass = 'Funstaff\Tika\Metadata';
    protected $outputFormat = 'xml';
    protected $outputMetadataFormat = 'text';
    protected $outputEncoding = 'UTF-8';
    protected $metadataOnly = false;

    /**
     * Constructor
     *
     * @param string $tikaPath  Path of tika binary
     * @param string $javaPath  Path of java binary
     */
    public function __construct($tikaPath, $javaPath = null)
    {
        $this->tikaPath = $tikaPath;
        if (!file_exists($tikaPath)) {
            throw new \InvalidArgumentException(sprintf(
                'The Tika binary "%s" does not exists.',
                $tikaPath
            ));
        }

        if ($javaPath && !file_exists($javaPath)) {
            throw new \InvalidArgumentException(sprintf(
                'The java binary "%s" does not exists.',
                $javaPath
            ));
        }
    }

    /**
     * Get Tika Binary Path
     *
     * @return $tikaPath    Path of tika binary
     */
    public function getTikaBinaryPath()
    {
        return $this->tikaPath;
    }

    /**
     * Get Java Binary Path
     *
     * @return $javaPath    Path of java binary
     */
    public function getJavaBinaryPath()
    {
        return $this->javaPath;
    }

    /**
     * Set Metadata Class
     *
     * @param string $class    FQN for metadata class
     */
    public function setMetadataClass($class)
    {
        $this->metadataClass = $class;

        return $this;
    }

    /**
     * Get Metadata Class
     *
     * @param string $metadataClass FQN for metadata class
     */
    public function getMetadataClass()
    {
        return $this->metadataClass;
    }

    /**
     * Set Output Format
     *
     * @param string $format
     *
     * @return Funstaff\Tika\ConfigurationInterface
     */
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

    /**
     * Get Output Format
     *
     * @return $string  Output format
     */
    public function getOutputFormat()
    {
        return $this->outputFormat;
    }

    /**
     * Set MetadataOnly
     *
     * @param boolean $metadata
     *
     * @return Funstaff\Tika\ConfigurationInterface
     */
    public function setMetadataOnly($metadata = false)
    {
        $this->metadataOnly = (bool) $metadata;

        return $this;
    }

    /**
     * Get MetadataOnly
     *
     * @return boolean $metadataOnly
     */
    public function getMetadataOnly()
    {
        return $this->metadataOnly;
    }

    /**
     * Set Output Encoding
     *
     * @param string $encoding
     *
     * @return Funstaff\Tika\ConfigurationInterface
     */
    public function setOutputEncoding($encoding)
    {
        $this->outputEncoding = $encoding;

        return $this;
    }

    /**
     * Get Output Encoding
     *
     * @return string $outputEncoding
     */
    public function getOutputEncoding()
    {
        return $this->outputEncoding;
    }
}
