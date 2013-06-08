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
    protected $metadata;
    protected $content;

    public function __construct($name, $path)
    {
        $this->name = $name;
        $this->path = $path;
        if (!file_exists($path)) {
            throw new \InvalidArgumentException(sprintf(
                'Document "%s" with path "%s" does not exists.',
                $name,
                $path
            ));
        }
    }

    public function getName()
    {
        return $this->name;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function setMetadata(MetadataInterface $metadata)
    {
        $this->metadata = $metadata;

        return $this;
    }

    public function getMetadata()
    {
        return $this->metadata;
    }
    
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    public function getContent()
    {
        return $this->content;
    }
}