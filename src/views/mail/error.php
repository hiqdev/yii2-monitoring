<?php

/**
 * @var yii\web\View
 * @var yii\web\Request $request
 */
$request = Yii::$app->request;

?>

URL: <?= $request->getAbsoluteUrl() ?><br>
REFERER: <?= $_SERVER['HTTP_REFERER'] ?><br>

<?php if (isset(Yii::$app->user->login)) : ?>
USER: <?= Yii::$app->user->login ?><br>
<?php endif ?>

<?php if (isset(Yii::$app->user->email)) : ?>
EMAIL: <?= Yii::$app->user->email ?><br>
<?php endif ?>

IP: <?= $request->getUserIp() ?><br>
AGENT: <?= $request->getUserAgent() ?><br>
<br>

LEVEL: <?= $level ?><br>
<?php if (!empty($category)) : ?>
CATEGORY: <?= $category ?><br>
<?php endif ?>
TIME: <?= $time ?><br>

<?php if (isset($debugUrl)) : ?>
DEBUG: <?= $debugUrl ?><br>
<br>
<?php endif ?>

<?= nl2br($text) ?><br>
