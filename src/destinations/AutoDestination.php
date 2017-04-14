<?php
/**
 * Errors and performance monitoring for Yii2 applications
 *
 * @link      https://github.com/hiqdev/yii2-monitoring
 * @package   yii2-monitoring
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2016-2017, HiQDev (http://hiqdev.com/)
 */

namespace hiqdev\yii2\monitoring\destinations;

use hiqdev\yii2\monitoring\Module;

/**
 * AutoDestination redierects output to first of enabled destinations.
 */
class RedirectDestination extends \yii\base\Object
{
    protected $destinations = [];

    public function setDestinations(array $list)
    {
        $this->destinations = $list;
    }

    public function getDestinations()
    {
        return $this->destinations;
    }

    public function export($message)
    {
        Module::getInstance()->exportMessage($this->destinations, $message);
    }
}
