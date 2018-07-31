### About coolsam/laravel-mongodb-transactions

Lately, Jensseger's laravel-mongodb package has become very popular among Laravel developers such as me who want to leverage the power of NoSQL databases,
specifically mongodb. I must say laravel-mongodb is perfect for ORM and Eloquent query building. However, one feature that lacks
is the ability to perform multi-document transactions while inserting or updating data in the DB.
I know mongoDB 4.x supports multi-document transactions but there is yet to exist a proper documentation on how this can be implemented in 
php, especially how it can be integrated to Jensseger's package. This package therefore extends Jenssegers/laravel-mongodb
with support to transactions.
##### Install
Assuming you have already installed ```composer require jenssegers/mongodb``` and configured it fully according to the documentation (https://packagist.org/packages/jenssegers/mongodb), now run this to install laravel-mongodb-transactions:

```composer require coolsam/laravel-mongodb-transactions```
#####Configuration
Then add the following service provider in config/app.php (Package auto discover might take care of this in Laravel ^5.5):

```php
Coolsam\Transactions\MongodbTransactionsServiceProvider::class
```

##### Usage

```php
$uuid = 'UUID';

Model::openTransactions($uuid);

AccountModel::where('a_uid', 123)->increment('a_money', 100);
// ........ A bunch of other db operations

Model::rollback($uuid); 
```
Or go ahead and commit the transaction if satisfied with it.
```php
$uuid = 'UUID';

Model::openTransactions($uuid);

AccountModel::where('a_uid', 123)->increment('a_money', 100);
// ........ A bunch of other db operations

Model::commit($uuid); 
```
