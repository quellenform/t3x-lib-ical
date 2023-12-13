[![Donate](https://img.shields.io/badge/Donate-PayPal-green.svg?style=for-the-badge)](https://www.paypal.me/quellenform)
[![Latest Stable Version](https://img.shields.io/packagist/v/quellenform/t3x-lib-ical?style=for-the-badge)](https://packagist.org/packages/quellenform/t3x-lib-ical)
[![TYPO3 11](https://img.shields.io/badge/TYPO3-11-%23f49700.svg?style=for-the-badge)](https://get.typo3.org/version/11)
[![TYPO3 12](https://img.shields.io/badge/TYPO3-12-%23f49700.svg?style=for-the-badge)](https://get.typo3.org/version/12)
[![License](https://img.shields.io/packagist/l/quellenform/t3x-lib-ical?style=for-the-badge)](https://packagist.org/packages/quellenform/t3x-lib-ical)

# TYPO3 Library: iCalendar

TYPO3 CMS Extension "lib_ical"

## What does it do?

This Extension acts as iCal-Service in TYPO3 which will be used by different Data-Providers.

## Add Providers

Install a Data-Provider for `EXT:lib_ical` or register your own with the following lines of code in `ext_localconf.php`

```php
\TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
        \Quellenform\LibIcal\IcalRegistry::class
    )->registerProvider(
        'eventnews',
        \Quellenform\LibIcalEventnews\Provider\EventnewsProvider::class,
        [
            'components' => 'vevent',
            'class' => \GeorgRinger\News\Domain\Repository\NewsRepository::class
        ]
    );
```

Add additional lines to your templates and use the provided ViewHelper:

```html
<ical:link class="btn btn-primary" provider="eventnews" additionalParams="{uid:newsItem.uid,custom:'value'}">Download</ical:link>
```

> Note: Since this is currently a beta version, only records of the type "vevent" are possible.
