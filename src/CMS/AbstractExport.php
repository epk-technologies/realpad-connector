<?php
namespace RealPadConnector\CMS;

use RealPadConnector\Object;
use RealPadConnector\Utils;

abstract class AbstractExport extends Object {

    /**
     * @param bool $as_string [optional]
     * @param string $string_format [optional]
     * @return \DateTime|null|string
     */
    function getCreationTime($as_string = false, $string_format = 'Y-m-d H:i:s')
    {
        return Utils::formatDateTime($this['creation-time'], $as_string, $string_format);

    }

    /**
     * @return int
     */
    function getDeveloperID()
    {
        return (int)$this['developer-id'];
    }

    /**
     * @return string
     */
    function getDeveloperName()
    {
        return (string)$this['developer-name'];
    }

    /**
     * @return string
     */
    function getURL()
    {
        return (string)$this['url'];
    }

    /**
     * @return string
     */
    function getTrackingID()
    {
        return (string)$this['tracking-id'];
    }

    /**
     * @return string
     */
    function getLogoResourceID()
    {
        return (string)$this['logo'];
    }

    /**
     * @return bool
     */
    function allowsReservations()
    {
        return !empty($this['allows-reservations']) && $this['allows-reservations'] !== 'false';
    }



}