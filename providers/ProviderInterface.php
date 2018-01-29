<?php

namespace yiicod\pagesizepager\providers;

interface ProviderInterface
{
    /**
     * Get storage state value
     *
     * @param string $key
     * @param $default
     *
     * @return mixed
     */
    public function getStorageState(string $key, $default = null);

    /**
     * Set storage state value
     *
     * @param string $key
     * @param $value
     */
    public function setStorageState(string $key, array $value);

    /**
     * Get page size
     *
     * @param string $gridIdentifier
     * @param string $sizeVar
     * @param int $default
     *
     * @return int
     */
    public function getPageSize(string $gridIdentifier, string $sizeVar = '', int $default = 10): int;
}
