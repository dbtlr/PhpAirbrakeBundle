<?php
namespace Nodrew\Bundle\PhpAirbrakeBundle\Airbrake;

use Airbrake\Notice;
use Airbrake\Configuration as AirbrakeConfiguration;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * The PhpAirbrakeBundle Console Client Loader.
 *
 * @package		Airbrake
 * @license		http://www.opensource.org/licenses/mit-license.php
 */
class Client extends Client
{
    protected $enabled = false;

    /**
     * @param string $apiKey
     * @param Symfony\Component\DependencyInjection\ContainerInterface $container
     * @param string|null $queue
     */
    public function __construct($apiKey, $envName, ContainerInterface $container, $queue=null, $apiEndPoint=null)
    {
        if (!$apiKey) {
            return;
        }

        $this->enabled = true;
        $controller    = 'None';

        $options = array(
            'environmentName' => $envName,
            'queue'           => $queue,
            'component'       => 'console',
            'action'          => 'none',
            'projectRoot'     => realpath($container->getParameter('kernel.root_dir').'/..'),
        );

        if(!empty($apiEndPoint)){
            $options['apiEndPoint'] = $apiEndPoint;
        }

        parent::__construct(new AirbrakeConfiguration($apiKey, $options));

    }
}
