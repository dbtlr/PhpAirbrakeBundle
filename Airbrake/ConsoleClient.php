<?php
namespace Nodrew\Bundle\PhpAirbrakeBundle\Airbrake;

use Airbrake\Client as AirbrakeClient;
use Airbrake\Notice;
use Airbrake\Configuration as AirbrakeConfiguration;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * The PhpAirbrakeBundle Console Client Loader.
 *
 * @package		Airbrake
 * @license		http://www.opensource.org/licenses/mit-license.php
 */
class ConsoleClient extends AirbrakeClient
{
    protected $enabled = false;

    /**
     * @param string $apiKey
     * @param Symfony\Component\DependencyInjection\ContainerInterface $container
     * @param string|null $queue
     * @param string|null $apiEndPoint
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

    public function setCommand($name)
    {
        $this->configuration->_action = $name;
    }

    /**
     * Notify about the notice.
     *
     * If there is a PHP Resque client given in the configuration, then use that to queue up a job to
     * send this out later. This should help speed up operations.
     *
     * @param Airbrake\Notice $notice
     */
    public function notify(Notice $notice)
    {
        if ($this->enabled) {
            parent::notify($notice);
        }
    }
}
