<?php

namespace Coolsam\Transactions\Query;

use Jenssegers\Mongodb\Query\Builder;
use Jenssegers\Mongodb\Connection;

class QueryBuilder extends Builder
{
    /**
     * @inheritdoc
     */
    public function __construct(Connection $connection, Processor $processor)
    {
        $this->grammar = new Grammar;
        $this->connection = $connection;
        $this->processor = $processor;
        $this->useCollections = $this->shouldUseCollections();
    }
}