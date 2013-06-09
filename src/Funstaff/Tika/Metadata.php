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
    protected $data = array();

    public function add($name, $value)
    {
        $this->data[$name] = $value;

        return $this;
    }

    public function get($name)
    {
        if (!array_key_exists($name, $this->data)) {
            throw new \InvalidArgumentException(sprintf(
                'The value for "%s" does not exists.',
                $name
            ));
        }

        return $this->data[$name];
    }
    
    public function getAll()
    {
        return $this->data;
    }
}