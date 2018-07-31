<?php

namespace Coolsam\Transactions\Event;

use \Illuminate\Database\Query\Builder as QueryBuilder;
use Coolsam\Transactions\Eloquent\Model;

class RecordTransactions extends BaseTransactions
{
    /**
     * @param QueryBuilder $query
     * @param string       $column
     * @param string       $uuid
     * @return bool
     */
    public static function backup(QueryBuilder $query, $column, $uuid)
    {
        if (Model::getTransactionsState() !== 'open') {
            return false;
        }

        $backupData = $query->get()->toArray();
        $driver     = parent::getDriver();
        $driver->setCollection(parent::getCollection());

        $driver->save($query->from, $query->wheres, $backupData, $column, $uuid);
    }
}