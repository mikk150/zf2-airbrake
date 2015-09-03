<?php

namespace Zf2Airbrake;


class EventHandler extends \Airbrake\EventHandler
{

    /**
     * @param \Airbrake\EventHandler $instance
     *
     * @return \Airbrake\EventHandler
     */
    public static function setInstance(\Airbrake\EventHandler $instance)
    {
        self::$instance = $instance;
        return self::$instance;
    }

}