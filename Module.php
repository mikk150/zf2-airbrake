<?php
namespace Zf2Airbrake;

use Zend\EventManager\EventInterface;
use Zend\ModuleManager\Feature\BootstrapListenerInterface;
use Zend\Console\Request as ConsoleRequest;
use Zend\Stdlib\ResponseInterface as Response;
use Zend\Mvc\Application;
use Zend\Mvc\MvcEvent;

class Module implements BootstrapListenerInterface
{

    /**
     * @var array
     */
    protected $noCatchExceptions = array();

    /**
     * {@inheritDoc}
     */
    public function onBootstrap(EventInterface $e)
    {
        var_dump($e);
    }
}
