<?php

declare(strict_types=1);

namespace hiqdev\yii2\monitoring\tests\unit;

use hiqdev\yii\compat\yii;
use yii\di\Container;

abstract class TestCase extends \PHPUnit\Framework\TestCase
{
    public function di(): Container
    {
        return yii::getContainer();
    }
}
