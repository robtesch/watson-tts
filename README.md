# watson-tts

A laravel package designed to help you make use of IBM's Watson Text-To-Speech (TTS) service.

## Installation

1) You can install this package within a new or existing laravel project using composer:

``` shell
composer require robtesch/watson_tts
```

3) If you're running Laravel >= 5.5, package discovery will configure the service provider and `Watsontts` alias out of the box.

    Otherwise, for Laravel <= 5.4, edit your `config/app.php` file and:

    - add the following to the `providers` array:
        ``` php
        Robtesch\Watsontts\WatsonServiceProvider::class,
        ```
    - add the following to the `aliases` array: 
        ``` php
        'Watsontts' => Robtesch\Watsontts\Facades\Watsontts::class,
        ```

4) Run the command below to publish the package config file [config/watson-tts.php](src/config/watson-tts.php):

``` shell
php artisan vendor:publish --provider="Robtesch\Watsontts\WatsonServiceProvider"
```

## Configuration

If you are planning to use a single account, you might want to add the following to
your `.env` file.

```
WATSON_ENDPOINT='https://stream.watsonplatform.net/text-to-speech/api'
WATSON_API_VERSION=v1
WATSON_USERNAME=someusername
WATSON_PASSWORD=somepassword
WATSON_FILESYSTEM_DISK=local
```

## Usage
#### Basic usage example
This is a basic example, which will echo out all Mails within all imap folders
and will move every message into INBOX.read. Please be aware that this should not ben
tested in real live but it gives an impression on how things work.

``` php
use Robtesch\Watsontts\Watsontts;

$watsonTts = new Watsontts();

$text = 'Watson Text-To-Speech Service allows me to turn text into audio clips.';
$voice = 'en-US_LisaVoice';

//You can optionally include or exclude the file extension in the path.
$savePath = storage_path('app/path/to/save.mp3');

//If you provide a file extension, you do not need to specify the "accept" param.
$accept = 'audio/mp3';

$synthesis = $watsonTts->synthesizeAudio($text, $voice, $savePath, $accept);

//Will return a Laravel file download response.
return $synthesis->download();
```

Alternatively, if you want to customise the credentials used to connect to watson, you can instantiate a client to pass to the Watson Service.

Either pass a config array to the Client:

```
use Robtesch\Watsontts\Watsontts;
use Robtesch\Watsontts\Client;

//Config values will be used for keys not present in the config array.
$config = [
    'endpoint' => 'someotherendpoint.com',
    'api_version' => 'someotherversion',
    'username' => 'username',
    'password' => 'password',
];

$client = new Client($config);

$watsonTts = new Watsontts($client);
```

Or set the values directly on the client:

```
use Robtesch\Watsontts\Watsontts;
use Robtesch\Watsontts\Client;

$client = new Client();

$client->setEndpoint('someotherendpoint.com');
$client->setApiVersion('someotherversion');
$client->setUsername('username');
$client->setPassword('password');

$watsonTts = new Watsontts($client);
```
