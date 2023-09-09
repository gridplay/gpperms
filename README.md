GridPlay Permissions
==================
Simple rank system for Laravel 8+

```bash
composer require gridplay/gpperms:dev-main
```

Publish the database
```bash
php artisan vendor:publish --provider="GGPerms\GPPermsServiceProvider" --tag="migrations"
```
Then migrate the database
```bash
php artisan migrate
```
After migrating the tables you may need to change user_id to a string if your user's ID is in UUID format instead of the default incrementing integer

OR can just manually add the table itself
Tables:
```gpperms_users```
- ```user_id``` = can be integer or string if your user's ID's are UUID
- ```rank_id``` = integer, will match what is in the config
- ```added``` = Big integer, unix time of when the user was added to the database
- ```updated``` = Big int, unix time of when the user's rank was changed

``gpperms_ranks``
- ```rank_id``` = auto increment integer
- ```rank_name``` = string, name of the rank

## Usage
```php
if (GPPerms::can(Auth::id(), 'Premium')) {
	// code here if approved
}
```