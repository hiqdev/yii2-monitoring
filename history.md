# hiqdev/yii2-monitoring

## [0.2.1] - 2017-10-10

- Improved default configuration a bit
    - [c746df2] 2017-10-10 csfixed [@hiqsol]
    - [ab7ed2b] 2017-10-10 removed manual ENV mixing, moving to composer-config-plugin [@hiqsol]
    - [4909683] 2017-09-28 fixed configuration [@hiqsol]
    - [43aeed3] 2017-09-27 improved building configuration [@hiqsol]

## [0.2.0] - 2017-05-05

- Renamed config `web` <- hisite
    - [977b466] 2017-05-05 renamed config `web` <- hisite [@hiqsol]
    - [59a613a] 2017-05-05 csfixed [@hiqsol]
    - [996b633] 2017-05-05 renamed `hidev.yml` <- .hidev/config.yml [@hiqsol]
    - [34b5801] 2017-04-25 fixed yii2 require condition [@hiqsol]
    - [a146ddc] 2017-04-25 + require yii2 [@hiqsol]
    - [028ee3a] 2017-04-25 fixed typo [@hiqsol]
    - [554b307] 2017-04-25 splitted config into common and hisite [@hiqsol]
- Fixed minor issues
    - [6a75417] 2017-04-25 Updated params.php [@SilverFire]
    - [c9cdc9d] 2017-04-25 Enhanced PHPDocs, minor refactoring [@SilverFire]
    - [e0fa86a] 2017-04-25 minor fixes [@hiqsol]
    - [c9ecbfe] 2017-04-25 split out `_request_data` view [@hiqsol]
    - [2a97e5c] 2017-04-19 fixed language file [@hiqsol]
    - [ea577c8] 2017-04-19 fixed RedirectMessage prevented sending context message [@hiqsol]

## [0.1.0] - 2017-04-19

- Fixed sending to Sentry
    - [7599208] 2017-04-19 removed bootstrap config checker [@hiqsol]
    - [148846f] 2017-04-19 docs [@hiqsol]
    - [04f6d02] 2017-04-19 docs [@hiqsol]
    - [d9470e4] 2017-04-19 docs [@hiqsol]
    - [d0fbede] 2017-04-19 docs [@hiqsol]
    - [f7bac3a] 2017-04-19 fixed sending to sentry [@hiqsol]
- Added basics: redone from `hiddev/yii2-error-notifier`
    - [ddfac1a] 2017-04-17 added h1 header to error/index page [@hiqsol]
    - [81eb2e5] 2017-04-15 csfixed [@hiqsol]
    - [6ceaf75] 2017-04-15 minor: changed title [@hiqsol]
    - [f45a0d0] 2017-04-15 fixed getting env in config [@hiqsol]
    - [5dbbd66] 2017-04-15 disabled sending email when not prod [@hiqsol]
    - [d87c8d6] 2017-04-14 fixed sending feedback [@hiqsol]
    - [cb85929] 2017-04-14 removed experiments [@hiqsol]
    - [a8d6a27] 2017-04-14 added debug URL to email [@hiqsol]
    - [8ba4fd8] 2017-04-14 EmailTarget works - sends emails [@hiqsol]
    - [142127a] 2017-04-14 rethought somewhere in the middle with targets and RedirectTarget [@hiqsol]
    - [31b0335] 2017-04-13 inited [@hiqsol]

## [Development started] - 2017-04-13

[@hiqsol]: https://github.com/hiqsol
[sol@hiqdev.com]: https://github.com/hiqsol
[@SilverFire]: https://github.com/SilverFire
[d.naumenko.a@gmail.com]: https://github.com/SilverFire
[@tafid]: https://github.com/tafid
[andreyklochok@gmail.com]: https://github.com/tafid
[@BladeRoot]: https://github.com/BladeRoot
[bladeroot@gmail.com]: https://github.com/BladeRoot
[ddfac1a]: https://github.com/hiqdev/yii2-monitoring/commit/ddfac1a
[81eb2e5]: https://github.com/hiqdev/yii2-monitoring/commit/81eb2e5
[6ceaf75]: https://github.com/hiqdev/yii2-monitoring/commit/6ceaf75
[f45a0d0]: https://github.com/hiqdev/yii2-monitoring/commit/f45a0d0
[5dbbd66]: https://github.com/hiqdev/yii2-monitoring/commit/5dbbd66
[d87c8d6]: https://github.com/hiqdev/yii2-monitoring/commit/d87c8d6
[cb85929]: https://github.com/hiqdev/yii2-monitoring/commit/cb85929
[a8d6a27]: https://github.com/hiqdev/yii2-monitoring/commit/a8d6a27
[8ba4fd8]: https://github.com/hiqdev/yii2-monitoring/commit/8ba4fd8
[142127a]: https://github.com/hiqdev/yii2-monitoring/commit/142127a
[31b0335]: https://github.com/hiqdev/yii2-monitoring/commit/31b0335
[Under development]: https://github.com/hiqdev/yii2-monitoring/compare/0.2.0...HEAD
[148846f]: https://github.com/hiqdev/yii2-monitoring/commit/148846f
[04f6d02]: https://github.com/hiqdev/yii2-monitoring/commit/04f6d02
[d9470e4]: https://github.com/hiqdev/yii2-monitoring/commit/d9470e4
[d0fbede]: https://github.com/hiqdev/yii2-monitoring/commit/d0fbede
[f7bac3a]: https://github.com/hiqdev/yii2-monitoring/commit/f7bac3a
[7599208]: https://github.com/hiqdev/yii2-monitoring/commit/7599208
[0.1.0]: https://github.com/hiqdev/yii2-monitoring/releases/tag/0.1.0
[977b466]: https://github.com/hiqdev/yii2-monitoring/commit/977b466
[59a613a]: https://github.com/hiqdev/yii2-monitoring/commit/59a613a
[996b633]: https://github.com/hiqdev/yii2-monitoring/commit/996b633
[34b5801]: https://github.com/hiqdev/yii2-monitoring/commit/34b5801
[a146ddc]: https://github.com/hiqdev/yii2-monitoring/commit/a146ddc
[028ee3a]: https://github.com/hiqdev/yii2-monitoring/commit/028ee3a
[554b307]: https://github.com/hiqdev/yii2-monitoring/commit/554b307
[6a75417]: https://github.com/hiqdev/yii2-monitoring/commit/6a75417
[c9cdc9d]: https://github.com/hiqdev/yii2-monitoring/commit/c9cdc9d
[e0fa86a]: https://github.com/hiqdev/yii2-monitoring/commit/e0fa86a
[c9ecbfe]: https://github.com/hiqdev/yii2-monitoring/commit/c9ecbfe
[2a97e5c]: https://github.com/hiqdev/yii2-monitoring/commit/2a97e5c
[ea577c8]: https://github.com/hiqdev/yii2-monitoring/commit/ea577c8
[0.2.0]: https://github.com/hiqdev/yii2-monitoring/compare/0.1.0...0.2.0
[c746df2]: https://github.com/hiqdev/yii2-monitoring/commit/c746df2
[ab7ed2b]: https://github.com/hiqdev/yii2-monitoring/commit/ab7ed2b
[4909683]: https://github.com/hiqdev/yii2-monitoring/commit/4909683
[43aeed3]: https://github.com/hiqdev/yii2-monitoring/commit/43aeed3
[0.2.1]: https://github.com/hiqdev/yii2-monitoring/compare/0.2.0...0.2.1
