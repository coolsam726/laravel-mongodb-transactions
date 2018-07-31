<?php

namespace Coolsam\Transactions\Drive;

interface DriverInterface
{
    /**
     * 驱动配置
     *
     * @param string $config
     *
     * @return mixed
     */
    public function setCollection($config);
}