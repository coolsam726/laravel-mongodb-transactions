<?php

namespace Viest\Transactions\Event;

class RollbackTransactions extends BaseTransactions
{
    /**
     * rollback
     *
     * @param string $uuid
     *
     * @return array
     */
    public static function rollback($uuid)
    {
        $driver     = parent::getDriver();
        $driver->setCollection(parent::getCollection());

        return $driver->rollback($uuid);
    }
}