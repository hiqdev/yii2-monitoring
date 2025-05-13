<?php

declare(strict_types=1);

namespace hiqdev\yii2\monitoring\bootstrap;

use hiqdev\yii2\monitoring\assets\SentryAsset;
use Sentry\SentrySdk;
use yii\base\ActionEvent;
use yii\base\BootstrapInterface;
use yii\web\Application;
use yii\web\View;
use Yii;

class SentryUserFeedbackBootstrap implements BootstrapInterface
{
    public function bootstrap($app): void
    {
        if ($app instanceof Application) {
            $app->on(Application::EVENT_BEFORE_ACTION, function (ActionEvent $event) use ($app) {
                $event->sender->view->on(View::EVENT_END_BODY, function () use ($app) {
                    $titleMsg = Yii::t('monitoring', 'Feedback');
                    $actionMsg = Yii::t('monitoring', 'Send Feedback');
                    $params = $app->params;
                    $view = $app->view;
                    if (empty($params['sentry.dsn']) || empty($params['sentry.enabled'])) {
                        return '';
                    }
                    SentryAsset::register($view);
                    $dsn = $params['sentry.dsn'];
                    $eventId = SentrySdk::getCurrentHub()->getLastEventId();
                    if ($eventId) {
                        $view->registerJs(<<<"JS"
                          ;(() => {
                            Sentry.init({
                              dsn: '$dsn',
                            });
                            $("#sentry-modal").on("click", function (e) {
                              e.preventDefault();
                              const btn = $(e.currentTarget).button('loading');
                              Sentry.showReportDialog({ 
                                eventId: "$eventId",
                                user: {
                                 name: '{$app->user->identity->login}',
                                 email: '{$app->user->identity->email}',
                                 lang: '{$app->language}',
                                },
                                onLoad() {
                                  btn.button('reset');
                                },
                              });
                            });
                          })();
JS
                            ,
                            View::POS_READY);
                    } else {
                        $view->registerJs(<<<"JS"
                          window.Sentry && Sentry.onLoad(function () {
                            Sentry.init({
                              dsn: "$dsn",
                              replaysSessionSampleRate: 0.1,
                              replaysOnErrorSampleRate: 1.0,
                              integrations: [
                                Sentry.replayIntegration({
                                  maskAllText: false,
                                  maskAllInputs: false,
                                  blockAllMedia: true,
                                  networkDetailAllowUrls: [window.location.origin],
                                }),
                              ],
                            });
                            Sentry.setUser({
                              username: "{$app->user->identity->login}",
                              email: "{$app->user->identity->email}",
                              lang: "{$app->language}",
                            });
                            Sentry.lazyLoadIntegration("feedbackIntegration").then((feedbackIntegration) => {
                              Sentry.addIntegration(
                                feedbackIntegration({
                                  showBranding: false,
                                  colorScheme: "system",
                                  enableScreenshot: true,
                                  triggerLabel: "$titleMsg",
                                  buttonLabel: "$titleMsg",
                                  submitButtonLabel: "$actionMsg",
                                  isNameRequired: true,
                                  isEmailRequired: true,
                                  formTitle: "$actionMsg",
                                }),
                              );
                            }).catch(() => {
                              // this can happen if e.g. a network error occurs,
                              // in this case User Feedback will not be enabled
                            });
                          });
JS
                            ,
                            View::POS_READY);
                    }
                    $view->registerCss("#sentry-feedback { --inset: auto auto 0 0; }");
                });
            });
        }
    }
}
