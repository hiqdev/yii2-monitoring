<?php

declare(strict_types=1);

namespace hiqdev\yii2\monitoring\assets;

use Yii;
use yii\web\AssetBundle;

class SentryAsset extends AssetBundle
{
    public ?string $loaderScript = null;

    public function init(): void
    {
        $hasDsn = Yii::$app->params['sentry.dsn'] ?? null;
        if ($hasDsn) {
            $this->js[] = [
                'https://browser.sentry-cdn.com/9.15.0/bundle.replay.min.js',
                'integrity' => 'sha384-Oga6v5QleFtkIvkUeujPxkllBiOc6G4eOPvRWGo80buOtgLhjgyN+vUalN/4ag+a',
                'crossorigin' => 'anonymous',
            ];
        }
    }
}
