<?php

namespace Coolsam\Transactions\Drive;


class RedisDriver implements DriverInterface
{
    /**
     * redis configuration
     *
     * @param array $config
     *
     * @return mixed|void
     */
    public function config(array $config)
    {

    }

    /**
     * 驱动配置
     *
     * @param string $config
     *
     * @return mixed
     */
    public function setCollection($config)
    {
        // TODO: Implement setCollection() method.
    }
}