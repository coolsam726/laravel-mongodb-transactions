<?php

namespace Viest\Transactions\Eloquent;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Viest\Transactions\Event\RollbackTransactions;
use Viest\Transactions\Query\QueryBuilder;

class Model extends Eloquent
{
    private static $transactionState = 'down';
    private static $transactionUUID  = '';

    /**
     * open transactions
     *
     * @author viest <dev@service.viest.me>
     *
     * @return void
     */
    public static function openTransactions($uuid)
    {
        self::$transactionState = 'open';
        self::$transactionUUID  = $uuid;
    }

    /**
     * down transactions
     *
     * @author viest <dev@service.viest.me>
     *
     * @return void
     */
    public static function downTransactions()
    {
        self::$transactionState = 'down';
    }

    public static function rollback($uuid)
    {
        return RollbackTransactions::rollback($uuid);
    }

    /**
     * get transactions state
     *
     * @return string
     */
    public static function getTransactionsState()
    {
        return self::$transactionState;
    }

    public static function getTransactionUUID()
    {
        return self::$transactionUUID;
    }

    /**
     * @return \Illuminate\Database\Query\Builder|\Jenssegers\Mongodb\Query\Builder|QueryBuilder
     */
    protected function newBaseQueryBuilder()
    {
        $connection = $this->getConnection();

        return new QueryBuilder($connection, $connection->getPostProcessor());
    }

    /**
     * @param \Illuminate\Database\Query\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Jenssegers\Mongodb\Eloquent\Builder|Builder|static
     */
    public function newEloquentBuilder($query)
    {
        return new Builder($query);
    }

    /**
     * @param string $method
     * @param array  $parameters
     *
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        if ($method == 'unset') {
            return call_user_func_array([$this, 'drop'], $parameters);
        }

        return parent::__call($method, $parameters);
    }
}