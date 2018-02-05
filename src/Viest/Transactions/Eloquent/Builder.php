<?php

namespace Viest\Transactions\Eloquent;

use Jenssegers\Mongodb\Eloquent\Builder as BaseBuilder;
use Viest\Transactions\Event\RecordTransactions;

class Builder extends BaseBuilder
{
    /**
     * increment
     *
     * @param string $column
     * @param int    $amount
     * @param array  $extra
     *
     * @return bool|int
     */
    public function increment($column, $amount = 1, array $extra = [])
    {
        RecordTransactions::backup($this->toBase(), $column, Model::getTransactionUUID());

        return parent::increment($column, $amount, $extra);
    }
}