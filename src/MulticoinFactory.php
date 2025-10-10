<?php

namespace Multicoin\Api;

use InvalidArgumentException;

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
    protected $currencies = [];

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
     * Pass methods onto the default currency.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     */
    public function __call(string $method, array $parameters)
    {
        return $this->currency()->{$method}(...$parameters);
    }

    /**
     * Gets currency instance by name or creates if not exists.
     *
     * @param  string  $name
     * @return \Multicoin\Api\Multicoin
     */
    public function currency(string $name = 'BTC'): Multicoin
    {
        if (! array_key_exists($name, $this->currencies)) {
            $config = $this->getConfig($name);

            $this->currencies[$name] = $this->make($config);
        }

        return $this->currencies[$name];
    }

    /**
     * Gets currency config by name.
     *
     * @param  string  $name
     * @return array
     */
    public function getConfig(string $name = 'BTC'): array
    {
        // Basic validation for the expected config shape
        if (! isset($this->config['currency']) || ! is_array($this->config['currency'])) {
            throw new InvalidArgumentException('Invalid configuration: "currency" list is missing or not an array.');
        }
        if (empty($this->config['url']) || ! is_string($this->config['url'])) {
            throw new InvalidArgumentException('Invalid configuration: "url" is missing or empty.');
        }
        if (empty($this->config['api_token']) || ! is_string($this->config['api_token'])) {
            throw new InvalidArgumentException('Invalid configuration: "api_token" is missing or empty.');
        }

        $flip_currency = array_flip($this->config['currency']);

        if (! array_key_exists($name, $flip_currency)) {
            throw new InvalidArgumentException(
                "Could not find currency configuration [$name]"
            );
        }

        return $this->withDefaults($this->config, $name);
    }

    /**
     * Creates currency instance.
     *
     * @param  array  $config
     * @return \Multicoin\Api\Multicoin
     */
    public function make(array $config = []): Multicoin
    {
        return new Multicoin($config);
    }

    /**
     * Appends configuration array with default values.
     *
     * @param  array  $config
     * @return array
     */
    protected function withDefaults(array $config, string $name): array
    {
        return array_merge(['coin' => $name], $config);
    }
}
