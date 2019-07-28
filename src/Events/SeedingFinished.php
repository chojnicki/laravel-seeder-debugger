<?php

namespace Chojnicki\LaravelSeederDebugger\Events;


class SeedingFinished
{

    public $debug;

    /**
     * Create a new event instance.
     *
     * @param array $debug
     */
    public function __construct($debug)
    {
        $this->debug = $debug;
    }
}
