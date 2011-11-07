<?php
namespace NoDrew\Bundle\PhpAirbrakeBundle\Airbrake;

use Airbrake\Client as AirbrakeClient;
use Airbrake\Configuration as AirbrakeConfiguration;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * The PhpAirbrakeBundle Client Loader.
 *
 * This class assists in the loading of the php-airbrake Client class.
 *
 * @package		Airbrake
 * @author		Drew Butler <drew@abstracting.me>
 * @copyright	(c) 2011 Drew Butler
 * @license		http://www.opensource.org/licenses/mit-license.php
 */
class Client extends AirbrakeClient
{
    /**
     * @param string $apiKey
     * @param Symfony\Component\DependencyInjection\ContainerInterface $container
     * @param string|null $queue
     */
    public function __construct($apiKey, $envName, ContainerInterface $container, $queue=null)
    {
        $request = $container->get('request');
        list($controller, $action) = explode('::', $request->attributes->get('_controller'));

        $options = array(
            'environmentName' => $envName,
            'queue'           => $queue,
            'serverData'      => $request->server->all(),
            'getData'         => $request->query->all(),
            'postData'        => $request->request->all(),
            'sessionData'     => $request->getSession()->all(),
            'component'       => $controller,
            'action'          => $action,
            'projectRoot'     => realpath($container->getParameter('kernel.root_dir').'/..'),
        );

        parent::__construct(new AirbrakeConfiguration($apiKey, $options));
    }
}
