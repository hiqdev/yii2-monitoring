<?php
declare(strict_types=1);

namespace hiqdev\yii2\monitoring\targets;

use Sentry\Event;
use Sentry\EventHint;
use Sentry\Severity;
use Sentry\State\HubInterface;
use Sentry\State\Scope;
use Throwable;
use yii\log\Logger;
use yii\log\Target;
use yii\web\User;
use Yii;

/**
 * SentryTarget records log messages in a Sentry.
 */
class SentryTarget extends Target
{
    private HubInterface $hub;
    private User $user;

    public function __construct(HubInterface $hub, User $user, $config = [])
    {
        parent::__construct($config);

        $this->hub = $hub;
        $this->user = $user;
    }

    /**
     * @inheritdoc
     */
    protected function getContextMessage()
    {
        return '';
    }

    /**
     * @inheritdoc
     */
    public function export()
    {
        foreach ($this->messages as $message) {
            [$msg, $level, $category] = $message;

            $event = Event::createEvent();
            $event->setLevel($this->getLogLevel($level));
            $event->setLogger('monolog.' . $category);

            $hint = new EventHint();

            if (is_array($msg)) {
                if (isset($msg['message'])) {
                    $event->setMessage($msg['message']);
                    unset($msg['message']);
                }
                if (isset($msg['exception']) && $msg['exception'] instanceof Throwable) {
                    $hint->exception = $msg['exception'];
                    unset($msg['exception']);
                }
            } else if (is_string($msg)) {
                $event->setMessage($msg);
            }

            $this->hub->withScope(function (Scope $scope) use ($msg, $event, $hint): void {
                if (is_array($msg)) {
                    foreach ($msg as $key => $value) {
                        $scope->setExtra((string) $key, $value);
                    }
                }

                $this->enrichWithUserData($scope);
                $this->hub->captureEvent($event, $hint);
            });
        }
    }

    /**
     * Translates Yii2 log levels to Sentry Severity.
     *
     * @param int $level
     * @return Severity
     */
    private function getLogLevel($level): Severity
    {
        switch ($level) {
            case Logger::LEVEL_PROFILE:
            case Logger::LEVEL_PROFILE_BEGIN:
            case Logger::LEVEL_PROFILE_END:
            case Logger::LEVEL_TRACE:
                return Severity::debug();
            case Logger::LEVEL_WARNING:
                return Severity::warning();
            case Logger::LEVEL_ERROR:
                return Severity::error();
            case Logger::LEVEL_INFO:
            default:
                return Severity::info();
        }
    }

    private function enrichWithUserData(Scope $scope): void
    {
        $data = [
            'ip_address' => Yii::$app->getRequest()->getUserIp(),
        ];

        if (!$this->user->isGuest) {
            $identity = $this->user->getIdentity();
            $data['id'] = $identity->id;
            $data['login'] = $identity->login ?? $identity->username ?? $identity->email ?? null;
            $data['email'] = $identity->email ?? null;
        }

        $scope->setUser(array_filter($data), true);
    }
}
