<?php
/**
 * Health monitoring for Yii2 applications.
 *
 * @link      https://github.com/hiqdev/yii2-monitoring
 * @package   yii2-monitoring
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2017, HiQDev (http://hiqdev.com/)
 */

namespace hiqdev\yii2\monitoring\targets;

use hiqdev\yii2\monitoring\Module;
use yii\log\Target;

/**
 * RedirectTarget redirects output to listed targets.
 */
class RedirectTarget extends \yii\log\Target
{
    protected $targets = [];

    public function setTargets($list)
    {
        $this->targets = $list;
    }

    public function getTargets()
    {
        return $this->targets;
    }

    public function export()
    {
        foreach ($this->getTargets() as $name) {
            $target = $this->getTarget($name);
            $target->messages = array_merge($target->messages, $this->messages);
            $target->export();
            $target->messages = [];
        }
    }

    /**
     * @param $name
     * @return Target
     */
    public function getTarget($name)
    {
        return $this->getModule()->getTarget($name);
    }

    public function getModule()
    {
        return Module::getInstance();
    }

    protected function getContextMessage()
    {
        return '';
    }
}
