# PhraseApp API client

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
