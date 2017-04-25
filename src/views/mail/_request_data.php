<?php

/** @var yii\web\Request $request */
$request  = Yii::$app->request;
$identity = isset(Yii::$app->user->identity) ? Yii::$app->user->identity : null;

$username = isset($identity->username) ? $identity->username : null;
$login    = isset($identity->login) ? $identity->login : null;
$email    = isset($identity->email) ? $identity->email : null;

?>

URL: <?= $request->getAbsoluteUrl() ?><br>
REFERER: <?= $_SERVER['HTTP_REFERER'] ?><br>

<?php if ($username || $login) : ?>
USER: <?= $username ?: $login ?><br>
<?php endif ?>
<?php if ($email) : ?>
EMAIL: <?= $email ?><br>
<?php endif ?>

IP: <?= $request->getUserIp() ?><br>
AGENT: <?= $request->getUserAgent() ?><br>
