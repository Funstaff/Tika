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
 * DocumentInterface
 *
 * @author Bertrand Zuchuat <bertrand.zuchuat@gmail.com>
 */
interface DocumentInterface
{
    function getName();
    function getPath();
    function getPassword();
    function setMetadata(MetadataInterface $metadata);
    function getMetadata();
    function setContent($content);
    function getContent();
    function setRawContent($content);
    function getRawContent();
}
