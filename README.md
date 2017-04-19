# Yii2 Monitoring

**Health monitoring for Yii2 applications**

[![Latest Stable Version](https://poser.pugx.org/hiqdev/yii2-monitoring/v/stable)](https://packagist.org/packages/hiqdev/yii2-monitoring)
[![Total Downloads](https://poser.pugx.org/hiqdev/yii2-monitoring/downloads)](https://packagist.org/packages/hiqdev/yii2-monitoring)
[![Build Status](https://img.shields.io/travis/hiqdev/yii2-monitoring.svg)](https://travis-ci.org/hiqdev/yii2-monitoring)
[![Scrutinizer Code Coverage](https://img.shields.io/scrutinizer/coverage/g/hiqdev/yii2-monitoring.svg)](https://scrutinizer-ci.com/g/hiqdev/yii2-monitoring/)
[![Scrutinizer Code Quality](https://img.shields.io/scrutinizer/g/hiqdev/yii2-monitoring.svg)](https://scrutinizer-ci.com/g/hiqdev/yii2-monitoring/)

Provides:

- Notifications for system administrators for uncaught exceptions and other errors
  sent through email or [Sentry]
- Feedback form on error pages for users could leave message for system administrators

## Installation

Add to required section of your `composer.json`:

```json
"hiqdev/yii2-monitoring": "*"
```

Out of the box this plugin supports used feedback form and
sending notifications to email.

To enable additional features require:

- [mito/yii2-sentry] - for sending to [Sentry]
- more later...

[Sentry]:           https://sentry.io/
[mito/yii2-sentry]: https://github.com/hellowearemito/yii2-sentry

## Configuration

This extension is supposed to be used with [composer-config-plugin].

Else look [src/config/hisite.php] for cofiguration example.

Available configuration parameters:

- `monitoring.email.from`
- `monitoring.email.to`
- `sentry.dsn`

[composer-config-plugin]:   https://github.com/hiqdev/composer-config-plugin
[src/config/hisite.php]:    src/config/hisite.php

## License

This project is released under the terms of the BSD-3-Clause [license](LICENSE).
Read more [here](http://choosealicense.com/licenses/bsd-3-clause).

Copyright © 2017, HiQDev (http://hiqdev.com/)
