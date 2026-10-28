This extension is supposed to be used with [composer-config-plugin].

Else look [src/config/hisite.php] for cofiguration example.

Available configuration parameters:

- `monitoring.email.from`
- `monitoring.email.to`
- `sentry.dsn`
- `sentry.environment` - defaults to `SENTRY_ENVIRONMENT`
- `sentry.tags` - tags added to every event, e.g. `['app' => 'my-app']`

[composer-config-plugin]:   https://github.com/hiqdev/composer-config-plugin
[src/config/hisite.php]:    src/config/hisite.php
