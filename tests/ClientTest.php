<?php
namespace Nodrew\Bundle\PhpAirbrakeBundle\Airbrake\Tests;

use Nodrew\Bundle\PhpAirbrakeBundle\Airbrake\Client;
use PHPUnit_Framework_MockObject_MockObject;
use PHPUnit_Framework_TestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class ClientTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var ContainerInterface|PHPUnit_Framework_MockObject_MockObject
     */
    private $container;

    protected function setUp()
    {
        parent::setUp();
        $this->container = $this->createMock(ContainerInterface::class);
    }

    public function testCreateNullSession()
    {
        $request = Request::create('/some-url');

        $this->container
            ->method('get')->with('request')
            ->willReturn($request);

        new Client(
            'api_key',
            'some_env',
            $this->container,
            'some_queue',
            'http://some.api/endpoint',
            false
        );
    }

    public function testCreateUnstartedSession()
    {
        $session = $this->createMock(Session::class);
        $session->method('isStarted')->willReturn(false);
        $session->expects(static::never())->method('has');
        $session->expects(static::never())->method('get');
        $session->expects(static::never())->method('set');
        $session->expects(static::never())->method('all');
        $session->expects(static::never())->method('replace');
        $session->expects(static::never())->method('remove');
        $session->expects(static::never())->method('clear');

        $request = Request::create('/some-url');
        $request->setSession($session);

        $this->container
            ->method('get')->with('request')
            ->willReturn($request);

        new Client(
            'api_key',
            'some_env',
            $this->container,
            'some_queue',
            'http://some.api/endpoint',
            false
        );
    }

    public function testCreateWithSession()
    {
        $session = $this->createMock(Session::class);
        $session->method('isStarted')->willReturn(true);

        $request = Request::create('/some-url');
        $request->setSession($session);

        $this->container
            ->method('get')->with('request')
            ->willReturn($request);

        new Client(
            'api_key',
            'some_env',
            $this->container,
            'some_queue',
            'http://some.api/endpoint',
            false
        );
    }
}