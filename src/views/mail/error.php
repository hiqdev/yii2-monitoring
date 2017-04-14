<?php

/**
 * @var yii\web\View $this
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

level: <?= $level ?><br>
<?php if (!empty($category)) : ?>
category: <?= $category ?><br>
<?php endif ?>
time: <?= $time ?><br>
<br>

<?= nl2br($text) ?><br>
