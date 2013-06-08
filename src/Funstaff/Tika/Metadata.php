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
 * Metadata
 *
 * @author Bertrand Zuchuat <bertrand.zuchuat@gmail.com>
 */
class Metadata implements MetadataInterface
{
    protected $raw;
    protected $format;

    public function __construct($raw, $format = 'text')
    {
        $this->raw = $raw;
        $this->format = $format;
    }

    public function getRaw()
    {
        return $this->raw;
    }

    public function getFormat()
    {
        return $this->format;
    }
}