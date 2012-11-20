PHP Airbrake Bundle for Symfony2
================================

This helps binds the [php-airbrake module](https://github.com/nodrew/php-airbrake) into a Symfony2 bundle for easy use with the framework. It will autoload an exception handler into the framework, so that all uncaught errors are sent to the [Airbrake Service](http://airbrake.io).

Installation Instructions
=========================

Using deps (for Symfony 2.0)
----------------------------

Add these blocks to the following files

*deps*

```
[PhpAirbrakeBundle]
    git=http://github.com/nodrew/PhpAirbrakeBundle.git
    target=/bundles/Nodrew/Bundle/PhpAirbrakeBundle

[php-airbrake]
    git=http://github.com/nodrew/php-airbrake.git
    target=/bundles/Nodrew/Bundle/PhpAirbrakeBundle/vendor/php-airbrake
```

*app/autoload.php*

```
$loader = new UniversalClassLoader();
$loader->registerNamespaces(array(
    ...
    'Nodrew'   => __DIR__.'/../vendor/bundles',
    ...
));
```

Using composer (for Symfony 2.1)
--------------------------------

The best way to install the library is by using [Composer](http://getcomposer.org). Add the following to `composer.json` in the root of your project:

``` javascript
{ 
  "require": {
    "nodrew/php-airbrake-bundle": "dev-master"
  }
}
```

Including bundle in Kernel
--------------------------

*app/AppKernel.php*

```
public function registerBundles()
{
    $bundles = array(
        // System Bundles
        ...
        new Nodrew\Bundle\PhpAirbrakeBundle\PhpAirbrakeBundle(),
        ...
    );
}
```

Configuration
-------------

*app/config/config.yml*

```
php_airbrake:
    api_key: %airbrake_api_key%
    api_endpoint: [optional custom API endpoint eg. http://api.airbrake.io/notifier_api/v2/notices]
    queue: [optional resqueue queue name]
```

*app/config/parameters.ini*

```
    airbrake_api_key="[airpbrake api key]"
```

Calling Airbrake Manually
=========================

The [Airbrake Client](https://github.com/nodrew/php-airbrake) can be found inside the Service Container and can be used like this:

```php
<?php
$client = $container->get('php_airbrake.client');

$client->notifyAboutError('Something really bad happened!');
$client->notifyAboutException(new Exception('Why did I catch this? It would have been caught on its own!?!'));
```

Resque Integration
==================

This client will allow for integration with PHPResque by providing the name of the Resque queue to add your error into. It is advisable that if you want to use PHPResque with Symfony2, that you use the [PHPResqueuBundle](https://github.com/hlegius/PHPResqueBundle) from [hlegius](https://github.com/hlegius), as it makes interfacing the worker processes with Symfony2 a breeze.

Once this is installed and running, simply fill in the *queue* config variable with the name of the queue you would like to use. I suggest just keeping it simple with something like 'airbrake'. Assuming you have a worker process running for this queue, you should be golden.

License
-------

This bundle is under the MIT license. See the complete license in the bundle:

    Resources/meta/LICENSE

About
-----

See also the list of [contributors](https://github.com/Nodrew/PhpAirbrakeBundle/contributors).

Reporting an issue or a feature request
---------------------------------------

Issues and feature requests are tracked in the [Github issue tracker](https://github.com/AbstractCodification/PhpAirbrakeBundle/issues).

When reporting a bug, it may be a good idea to reproduce it in a basic project
built using the [Symfony Standard Edition](https://github.com/symfony/symfony-standard)
to allow developers of the bundle to reproduce the issue by simply cloning it
and following some steps.
