<?php

namespace Multicoin\Api;

use InvalidArgumentException;
use Multicoin\Api\Multicoin as Multicoincurrency;

class MulticoinFactory
{
    /**
     * currency configurations.
     *
     * @var array
     */
    protected $config;

    /**
     * currency instances.
     *
     * @var array
     */
    protected $currencys = [];

    /**
     * Constructs currency factory instance.
     *
     * @param  array  $config
     * @return void
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * Appends configuration array with default values.
     *
     * @param  array   $config
     * @return array
     */
    protected function withDefaults(array $config, string $name): array
    {
        return array_merge(['coin' => $name], $config);
    }

    /**
     * Gets currency config by name.
     *
     * @param  string  $name
     * @return array
     */
    public function getConfig(string $name = 'BTC'): array
    {
        $flip_currency = array_flip($this->config['currency']);

        if (!array_key_exists($name, $flip_currency)) {
            throw new InvalidArgumentException(
                "Could not find currency configuration [$name]"
            );
        }

        return $this->withDefaults($this->config, $name);
    }

    /**
     * Gets currency instance by name or creates if not exists.
     *
     * @param  string                     $name
     * @return \Multicoin\Api\Multicoin
     */
    public function currency(string $name = 'BTC'): Multicoincurrency
    {
        if (!array_key_exists($name, $this->currencys)) {
            $config = $this->getConfig($name);

            $this->currencys[$name] = $this->make($config);
        }

        return $this->currencys[$name];
    }

    /**
     * Creates currency instance.
     *
     * @param  array                      $config
     * @return \Multicoin\Api\Multicoin
     */
    public function make(array $config = []): Multicoincurrency
    {
        return new Multicoincurrency($config);
    }

    /**
     * Pass methods onto the default currency.
     *
     * @param  string  $method
     * @param  array   $parameters
     * @return mixed
     */
    public function __call(string $method, array $parameters)
    {
        return $this->currency()->{$method}
        (...$parameters);
    }

}
