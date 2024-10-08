# Qrcode Library

[![Documentation Status](https://readthedocs.org/projects/qrcode-library/badge/?version=latest)](http://qrcode-library.readthedocs.io/en/latest/?badge=latest)
[![Packagist Version](https://img.shields.io/packagist/v/2amigos/qrcode-library.svg?style=flat-square)](https://packagist.org/packages/2amigos/qrcode-library)
[![Build Status](https://travis-ci.org/2amigos/qrcode-library.svg?branch=master)](https://travis-ci.org/2amigos/qrcode-library)
[![Latest Stable Version](https://poser.pugx.org/2amigos/qrcode-library/version)](https://packagist.org/packages/2amigos/qrcode-library)
[![Total Downloads](https://poser.pugx.org/2amigos/qrcode-library/downloads)](https://packagist.org/packages/2amigos/qrcode-library)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/2amigos/qrcode-library/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/2amigos/qrcode-library/?branch=master)

The library provides developers with the tools to generate Qr codes with ease. It is a total refactored version of the 
previous named yii2-qrcode-helper which was based on the ported PHP version of the libqrencode C library.  

This new version is highly inspired by the great work of [BaconQrCode](https://github.com/Bacon/BaconQrCode), in fact, 
it uses a modified version of its code for the writers included on this package.  

## Getting Started

### Supported PHP Versions  
| Tag | PHP Version |
| :---: |:----------:|
| ^ 3.0.2 |  7.3 - 8.0 |
| 3.1.0 |  7.4 - 8.1 |

### Server Requirements

- PHP >= 7.4
- Imagick
- GD
- FreeType

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require 2amigos/qrcode-library:^3.1.0
```
or add

```json
{
  ...
  "2amigos/qrcode-library": "^3.1.0"
}
```

### Usage 

The use of the library is quite easy when working as standalone. For example: 

```php
<?php 

use Da\QrCode\QrCode;

$qrCode = (new QrCode('This is my text'))
    ->setSize(250)
    ->setMargin(5)
    ->setBackgroundColor(51, 153, 255);

// now we can display the qrcode in many ways
// saving the result to a file:

$qrCode->writeFile(__DIR__ . '/code.png'); // writer defaults to PNG when none is specified

// display directly to the browser 
header('Content-Type: '.$qrCode->getContentType());
echo $qrCode->writeString();

?> 

<?php 
// or even as data:uri url
echo '<img src="' . $qrCode->writeDataUri() . '">';
?>
```

You can set the foreground color, defining RGBA values, where the alpha is optional.

```PHP
$qrCode = (new QrCode('This is my text'))
    ->setForeground(0, 0, 0);

// or, setting alpha as well
$qrCode = (new QrCode('This is my text'))
    ->setForeground(0, 0, 0, 50);
```

### Formats

In order to ease the task to write different formats into a QrCode, the library comes with a set of classes. These are: 

-  [BookmarkFormat](formats/bookmark.md)
-  [BtcFormat](formats/bitcoin.md) 
-  [GeoFormat](formats/geo.md)
-  [ICalFormat](formats/ical.md)
-  [MailMessageFormat](formats/mail-message.md)
-  [MailToFormat](formats/mail-to.md) 
-  [MeCardFormat](formats/me-card.md)
-  [MmsFormat](formats/mms.md)
-  [PhoneFormat](formats/phone.md)
-  [SmsFormat](formats/sms.md)
-  [VCardFormat](formats/vcard.md)
-  [WifiFormat](formats/wifi.md)
-  [YoutubeFormat](formats/youtube.md)

Laravel
----

This library bundles a blade component and a file route to easily work with the Laravel framework.

- [LaravelBladeComponent](laravel/blade-component.md)
- [File Route](laravel/file-route.md)
- [Customization](laravel/customization.md)

Yii2 
----

This library comes also with two special classes to specifically work with the Yii2 framework. These are: 

-  [QrCodeComponent](yii/qrcode-component.md)
-  [QrCodeAction](yii/qrcode-action.md)

Helpful Guides
--------------

-  [Advanced Usage](helpful-guides/advance-usage.md)
-  [Working with QrCodeComponent and QrCodeAction](helpful-guides/working-with-qrcode-component-and-qrcode-action.md)

Contributing
------------

-  [How to Contribute](contributing/how-to.md)
-  [Clean Code](contributing/clean-code.md)


© [2amigos](https://2am.tech/) 2013-2023
