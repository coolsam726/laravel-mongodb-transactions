### php-mongodb-transactions

##### Install

And add the service provider in config/app.php:

```php
Viest\Transactions\MongodbTransactionsServiceProvider::class
```

##### Use

```php
$uuid = 'UUID';

Model::openTransactions($uuid);

AccountModel::where('a_uid', 123)->increment('a_money', 100);
// ........

Model::rollback($uuid);
```
