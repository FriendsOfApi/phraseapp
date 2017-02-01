# PhraseApp API client

[![Latest Version](https://img.shields.io/github/release/FriendsOfApi/phraseapp.svg?style=flat-square)](https://github.com/FriendsOfApi/phraseapp/releases)
[![Build Status](https://img.shields.io/travis/FriendsOfApi/phraseapp/master.svg?style=flat-square)](https://travis-ci.org/FriendsOfApi/phraseapp)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/FriendsOfApi/phraseapp.svg?style=flat-square)](https://scrutinizer-ci.com/g/FriendsOfApi/phraseapp)
[![Quality Score](https://img.shields.io/scrutinizer/g/FriendsOfApi/phraseapp.svg?style=flat-square)](https://scrutinizer-ci.com/g/FriendsOfApi/phraseapp)
[![Total Downloads](https://img.shields.io/packagist/dt/friendsofapi/phraseapp.svg?style=flat-square)](https://packagist.org/packages/FriendsOfApi/phraseapp)

A community client for [PhraseApp](https://phraseapp.com).

## Install

Via Composer

``` bash
$ composer require friendsofapi/phraseapp
```

## Usage

```php
$apiClient = new PhraseAppClient();

$response = $apiClient->import()->import($projectId, 'symfony_xliff', $fileName, [
    'locale_id' => $localeId,
    'tags' => $domain,
]);

$response = $this->client->export()->locale($projectId, $localeId, 'symfony_xliff', [
    'tag' => $domain
]);
```

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.

## Contribute

Do you want to make a change? Pull requests are welcome.
