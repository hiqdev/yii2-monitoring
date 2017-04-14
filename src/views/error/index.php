<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\web\JsExpression;

/** @var $this yii\web\View */
/** @var $name string */
/** @var $message string */
/** @var $exception Exception */
/** @var $model \hiqdev\yii2\monitoring\models\FeedbackForm */
$this->title = $name;

?>

<div class="site-error">

    <div class="alert alert-danger">
        <?= nl2br(Html::encode($message)) ?>
    </div>

    <p>
        <?= Yii::t('monitoring', 'The error occurred while the Web server was processing your request.') ?>
    </p>
    <p>
        <?= Yii::t('monitoring', 'If you think this error is our fault, please contact us by pressing the button bellow.') ?>
        <br />
        <?= Yii::t('monitoring', 'We will inspect your report and fix the problem as soon as possible.') ?>
    </p>

    <div class="row">
        <div class="col-md-5 problem-report-form">
            <?= Html::button(Yii::t('monitoring', 'Report this problem'), [
                'class' => 'btn btn-warning report',
                'onclick' => new JsExpression("$(this).hide();$('#problem-report-form').show()"),
            ]) ?>

            <?php $form = ActiveForm::begin([
                'id' => 'problem-report-form',
                'action' => '/monitoring/error/send',
                'options' => ['style' => 'display: none'],
            ]) ?>

            <?= $form->field($model, 'session_tag')->hiddenInput()->label(false); ?>

            <?php if (Yii::$app->user->isGuest): ?>
                <?= $form->field($model, 'email')
                    ->hint(Yii::t('monitoring', 'This field is optional. In case you fill it, we will contact you to notify that the problem is fixed')) ?>
            <?php endif; ?>

            <?= $form->field($model, 'message')
                ->textarea()
                ->hint(Yii::t('monitoring', 'Maybe, you have clicked a wrong link, or tried to perform some action, but ended up on this page. Please, provide as many details as possible to give us a chance to reproduce your way and fix this problem.'));
            ?>
            <?= Html::submitButton(Yii::t('monitoring', 'Submit'), ['class' => 'btn btn-default']) ?>
            <?php $form->end(); ?>
        </div>
    </div>
</div>
