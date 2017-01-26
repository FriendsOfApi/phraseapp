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
$response = $apiClient->translations()->show('project_key', 'hello_world', 'sv');
echo $response->getTranslation(); // "Hej världen"
```

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.

