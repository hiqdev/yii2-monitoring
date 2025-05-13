<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\web\JsExpression;

/** @var yii\web\View $this */
/** @var string $name */
/** @var string $message */
/** @var Exception $exception */
/** @var hiqdev\yii2\monitoring\models\FeedbackForm $model */

$this->title = $name;

?>

<div class="row">
    <div class="site-error col-lg-4 col-lg-offset-4 col-md-6 col-md-offset-3 text-center">

        <?= Html::tag('h2', nl2br(Html::encode($message)), ['class' => 'text-danger']) ?>

        <p>
            <?= Yii::t('monitoring', 'The error occurred while the Web server was processing your request.') ?>
        </p>
        <p>
            <?= Yii::t('monitoring', 'If you think this error is our fault, please contact us by pressing the button below.') ?>
            <br/>
            <?= Yii::t('monitoring', 'We will inspect your report and fix the problem as soon as possible.') ?>
        </p>

        <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 2rem; margin-top: 3rem;">
            <?= Html::button(Yii::t('monitoring', 'Create Crash-Report to Sentry'), [
                'id' => 'sentry-modal',
                'class' => 'btn bg-purple',
                'data' => [
                    'loading-text' => Yii::t('monitoring', 'Loading...'),
                ],
            ]) ?>
            <span><?= Yii::t('monitoring', 'or') ?></span>
            <?= Html::button(Yii::t('monitoring', 'Report this problem'), [
                'class' => 'btn btn-danger report',
                'onclick' => new JsExpression("$(this).hide();$('#problem-report-form').show()"),
            ]) ?>
        </div>

        <?php $form = ActiveForm::begin([
            'id' => 'problem-report-form',
            'action' => '/monitoring/error/send',
            'options' => ['style' => 'display: none'],
        ]) ?>

        <?= $form->field($model, 'session_tag')->hiddenInput()->label(false) ?>

        <?php if (Yii::$app->user->isGuest): ?>
            <?= $form->field($model, 'email')
                ->hint(Yii::t('monitoring',
                    'This field is optional. In case you fill it, we will reach out to you to notify that the problem is fixed.')) ?>
        <?php endif ?>

        <?= $form
            ->field($model, 'message')
            ->textarea(['rows' => 6])
            ->hint(
                Yii::t('monitoring',
                    'Maybe, you have clicked a wrong link, or tried to perform some action, but ended up on this page. Please, provide as many details as possible to give us a chance to reproduce your way and fix this problem.')
            );
        ?>
        <?= Html::submitButton(Yii::t('monitoring', 'Submit'), ['class' => 'btn btn-success']) ?>
        <?php ActiveForm::end() ?>
    </div>
</div>
