<?php

namespace Coolsam\Transactions;

use Jenssegers\Mongodb\Connection as BaseConnection;

class Connection extends BaseConnection
{
    /**
     * Create a new database connection instance.
     *
     * @param  array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
        // Build the connection string
        $dsn = $this->getDsn($config);
        // You can pass options directly to the MongoDB constructor
        $options = array_get($config, 'options', []);
        // Create the connection
        $this->connection = $this->createConnection($dsn, $config, $options);
        // Select database
        $this->db = $this->connection->selectDatabase($config['database']);
        $this->useDefaultPostProcessor();
        $this->useDefaultSchemaGrammar();
        $this->useDefaultQueryGrammar();
    }

    /**
     * @inheritdoc
     */
    protected function getDefaultPostProcessor()
    {
        return new Query\Processor();
    }
}