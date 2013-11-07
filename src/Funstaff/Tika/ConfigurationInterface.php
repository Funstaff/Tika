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
 * ConfigurationInterface
 *
 * @author Bertrand Zuchuat <bertrand.zuchuat@gmail.com>
 */
interface ConfigurationInterface
{
    function getTikaBinaryPath();
    function setOutputFormat($format);
    function getOutputFormat();
    function setMetadataOnly($metadata);
    function getMetadataOnly();
    function setOutputEncoding($encoding);
    function getOutputEncoding();
}
