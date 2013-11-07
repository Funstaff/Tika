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
class Document implements DocumentInterface
{
    protected $name;
    protected $path;
    protected $password;
    protected $metadata;
    protected $content;
    protected $raw;

    /**
     * Construct
     *
     * @param $name Name of document
     * @param $path Path of document
     * @param $password Password for encrypted document
     */
    public function __construct($name, $path, $password = null)
    {
        $this->name = $name;
        $this->path = $path;
        $this->password = $password;
        if (!file_exists($path)) {
            throw new \InvalidArgumentException(sprintf(
                'Document "%s" with path "%s" does not exists.',
                $name,
                $path
            ));
        }
    }

    /**
     * Get Name
     *
     * @return string   name of document
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get Path
     *
     * @return string   path of document
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Get Password
     *
     * @return string   password of document
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set Metadata
     *
     * @param $metadata Funstaff\Tika\MetadataInterface
     *
     * @return Funstaff\Tika\DocumentInterface
     */
    public function setMetadata(MetadataInterface $metadata)
    {
        $this->metadata = $metadata;

        return $this;
    }

    /**
     * Get Metadata
     *
     * @return Funstaff\Tika\MetadataInterface
     */
    public function getMetadata()
    {
        return $this->metadata;
    }

    /**
     * Set Content
     *
     * @param string $content   Content of document
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get Content
     *
     * @return string content of document
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Get Raw Content
     *
     * @param string $content
     *
     * @return Funstaff\Tika\MetadataInterface
     */
    public function setRawContent($content)
    {
        $this->raw = $content;

        return $this;
    }

    /**
     * Get Raw Content
     *
     * @return string $raw
     */
    public function getRawContent()
    {
        return $this->raw;
    }
}
