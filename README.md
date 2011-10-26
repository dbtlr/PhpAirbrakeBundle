PHP Airbrake Bundle for Symfony2
================================

This helps binds the [php-airbrake module](https://github.com/nodrew/php-airbrake) into a Symfony2 bundle for easy use with the framework. It will autoload an exception handler into the framework, so that all uncaught errors are sent to the [Airbrake Service](http://airbrake.io).

Installation Instructions
=========================

Add these blocks to the following files

*deps*

```
[PhpAirbrakeBundle]
    git=http://github.com/nodrew/PhpAirbrakeBundle.git
    target=/PhpAirbrakeBundle
   
[php-airbrake]
    git=http://github.com/nodrew/php-airbrake.git
    target=/PhpAirbrakeBundle/vendor/php-airbrake
```

*app/autoload.php*

```
$loader = new UniversalClassLoader();
$loader->registerNamespaces(array(
    ...
    'PhpAirbrakeBundle'      => __DIR__.'/../vendor/',
    ...
));
```

*app/AppKernel.php*

```
public function registerBundles()
{
    $bundles = array(
        // System Bundles
        ...
        new PhpAirbrakeBundle\PhpAirbrakeBundle(),
        ...
    );
}
```

*app/config/config.yml*

```
php_airbrake:
    api_key: [your api key]
    queue: [optional resqueue queue name]
```
