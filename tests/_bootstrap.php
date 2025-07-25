<?php

use Yiisoft\Composer\Config\Builder;

define('APP_TYPE', 'tests');

error_reporting(E_ALL);
date_default_timezone_set('UTC');

$config = require Builder::path('web');

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../../../yiisoft/yii2/Yii.php';

$path = dirname(__DIR__);
$config['id'] = 'test-app';
$config['basePath'] = $path;

\Yii::setAlias('@root', $path);
\Yii::$app = new \yii\web\Application($config);
