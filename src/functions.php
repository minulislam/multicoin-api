<?php

if (! function_exists('multicoin')) {
    /**
     * Get bitcoind client instance by name.
     *
     * @return \Multicoin\Api\MulticoinFactory
     */
    function multicoin(): MulticoinFactory
    {
        return app('multicoin');
    }
}
