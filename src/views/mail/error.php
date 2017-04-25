<?php

/** @var yii\web\View $this */
$request = Yii::$app->request;

?>
<?= $this->render('_request_data.php') ?>
<br>

<?php if (!empty($level)) : ?>
LEVEL: <?= $level ?><br>
<?php endif ?>
<?php if (!empty($category)) : ?>
CATEGORY: <?= $category ?><br>
<?php endif ?>
<?php if (!empty($time)) : ?>
TIME: <?= $time ?><br>
<?php endif ?>
<?php if (isset($debugUrl)) : ?>
DEBUG: <?= $debugUrl ?><br>
<?php endif ?>

<br>
<?= nl2br($text) ?><br>
