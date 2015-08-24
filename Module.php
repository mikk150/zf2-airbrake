<?php
namespace Zf2Airbrake;

use Zend\EventManager\EventInterface;
use Zend\ModuleManager\Feature\BootstrapListenerInterface;
use Zend\Console\Request as ConsoleRequest;
use Zend\Stdlib\ResponseInterface as Response;
use Zend\Mvc\Application;
use Zend\Mvc\MvcEvent;
use Airbrake\EventHandler;

class Module implements BootstrapListenerInterface
{

    /**
     * @var array
     */
    protected $noCatchExceptions = array();


    protected $client;
    /**
     * {@inheritDoc}
     */
    public function onBootstrap(EventInterface $event)
    {
        
        $config  = $event->getTarget()->getServiceManager()->get('Config');
        $config  = isset($config['airbrake']) ? $config['airbrake'] : array();


        EventHandler::start($config['apiKey'], $config['notifyOnWarning'], $config['options']);
    }
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
}
