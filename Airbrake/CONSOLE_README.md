Example app/console using Airbrake ConsoleClient

```php
#!/usr/bin/env php
<?php

// Set $env, $debug params etc

$input = new ArgvInput();

$kernel = new AppKernel($env, $debug);
$application = new Application($kernel);
$application->setCatchExceptions(false);

try{
    $application->run($input);
} catch (Exception $e){
    $client = $kernel->getContainer()->get('php_airbrake.console_client');
    $client->setCommand($input->getFirstArgument());
    $client->notifyOnException($e);

    echo 'Exception - '.$e->getMessage();
}

```