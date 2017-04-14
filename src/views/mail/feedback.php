<?php

/**
 * @var \yii\web\View
 * @var \hiqdev\yii2\monitoring\models\FeedbackForm $form
 */
?>

<?= Yii::t('monitoring', 'User have submitted a report in response to an error.') ?>
<br />
<?php if (Yii::$app->user->isGuest) : ?>
    <?= Yii::t('monitoring', 'Contact email: {email}', ['email' => (string) $form->email]) ?>
<?php elseif (!empty(Yii::$app->user->identity->username)): ?>
    <?= Yii::t('monitoring', 'Username: {username}', ['username' => Yii::$app->user->identity->username]) ?>
<?php endif ?>
<br />
<?php if ($form->session_tag) : ?>
    <?= Yii::t('monitoring', 'See related debug session log: {url}', ['url' => $form->getDebugSessionUrl()]) ?>
    <br />
    <?= Yii::t('monitoring', 'The link may be invalidated by the GC, but this session is saved to a backup directory. Session tag: {tag}', ['tag' => $form->session_tag]) ?>
<?php endif ?>

<br />
<br />

<?= $form->message ?>
