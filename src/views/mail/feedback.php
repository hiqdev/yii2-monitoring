<?php

/**
 * @var \yii\web\View
 * @var \hiqdev\yii2\monitoring\models\FeedbackForm $form
 */
?>

<?= Yii::t('monitoring', 'User have submitted a report in response to an error.') ?>
<br />

<?php if ($form->session_tag) : ?>
    <?= Yii::t('monitoring', 'See related debug session log: {url}', ['url' => $form->getDebugUrl()]) ?>
    <br />
    <?= Yii::t('monitoring', 'The link may be invalidated by the GC, but this session is saved to a backup directory. Session tag: {tag}', ['tag' => $form->session_tag]) ?>
<?php endif ?>
<br />
<br />

<?= $form->message ?>
<br />
<br />

<?= $this->render('_request_data.php') ?>
