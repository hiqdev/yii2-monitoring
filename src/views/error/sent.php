<?php

/**
 * @var \yii\web\View
 * @var \hiqdev\yii2\monitoring\models\FeedbackForm $model
 * @var bool $success
 */
?>

<?php if ($success) : ?>
    <h3><?= Yii::t('monitoring', 'Thank you very much for your report!') ?></h3>
    <h5><?= Yii::t('monitoring', 'We will do our best to analyze it as soon as possible.') ?></h5>
<?php else : ?>
    <h3><?= Yii::t('monitoring', 'Oh snap.') ?></h3>
    <h5><?= Yii::t('monitoring', 'For some reasons the system failed to deliver your message to developers. Most probably it is a application-wide problem and they are already working on fix.') ?></h5>
<?php endif; ?>
