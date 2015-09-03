<?php
namespace Zf2Airbrake;

use Airbrake\Client;
use Airbrake\Configuration;
use Airbrake\EventFilter\Error\ErrorReporting;
use Airbrake\EventFilter\Exception\AirbrakeExceptionFilter;
use Zend\EventManager\EventInterface;
use Zend\ModuleManager\Feature\BootstrapListenerInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

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

        $config = $event->getTarget()->getServiceManager()->get('Config');
        $config  = isset($config['airbrake']) ? $config['airbrake'] : array();

        /** @var Client $airbrake */
        $airbrake  = $event->getTarget()->getServiceManager()->get('zf2_airbrake');

        $handler = new EventHandler($airbrake, $config['notifyOnWarning']);
        $handler->setInstance($handler);

        if (null !== $airbrake->getConfiguration()->get('errorReportingLevel')) {
            $handler->addErrorFilter(new ErrorReporting($airbrake->getConfiguration()));
        }

        $handler->addExceptionFilter(new AirbrakeExceptionFilter());

        set_error_handler(array($handler, 'onError'));
        set_exception_handler(array($handler, 'onException'));
        register_shutdown_function(array($handler, 'onShutdown'));

    }
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getServiceConfig() {

        return array(
            'factories' => array(
                'zf2_airbrake' => function (ServiceLocatorInterface $serviceLocator) {

                    $config = $serviceLocator->get('Config');
                    $config  = isset($config['airbrake']) ? $config['airbrake'] : array();

                    return new Client(new Configuration($config['apiKey'], $config['options']));
                }
            ),
        );
    }

}
