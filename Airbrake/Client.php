<?php
namespace PhpAirbrakeBundle\Airbrake;

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
class Client
{
    protected $container;

    /**
     * Takes the Symfony2 Container object as a parameter.
     *
     * @param Symfony\Component\DependencyInjection\ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }
}
