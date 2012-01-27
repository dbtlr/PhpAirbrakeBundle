<?php
namespace Nodrew\Bundle\PhpAirbrakeBundle\EventListener;

use Nodrew\Bundle\PhpAirbrakeBundle\Airbrake\Client;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;

/**
 * The PhpAirbrakeBundle ExceptionListener.
 *
 * Handles exceptions that occur in the code base.
 *
 * @package		Airbrake
 * @author		Drew Butler <drew@abstracting.me>
 * @copyright	(c) 2011 Drew Butler
 * @license		http://www.opensource.org/licenses/mit-license.php
 */
class ExceptionListener
{
    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $this->client->notifyOnException($event->getException());
    }
}
