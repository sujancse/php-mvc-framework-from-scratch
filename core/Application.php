<?php

namespace Core;

/**
 * Application dependency injection container.
 */
class Application
{
    protected $registry = [];

    /**
     * Binding values to DI container.
     *
     * @param  sting
     * @param  mixed
     */
    public function bind($key, $value)
    {
        $this->registry[$key] = $value;
    }

    /**
     * Get value from DI container by key.
     *
     * @param  string
     *
     * @return mixed
     */
    public function get($key)
    {
        if (!array_key_exists($key, $this->registry)) {
            throw new Exception("No data found with {$key}");
        }

        return $this->registry[$key];
    }
}
