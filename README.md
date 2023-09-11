GridPlay Permissions
==================
Simple rank system for Laravel 8+

Needed one for all my sites so instead of manually coping files from site to site i wrote this

This uses Laravel's Auth and DB facades hense why its 8+

```bash
composer require gridplay/gpperms
```

Publish the database
```bash
php artisan vendor:publish --provider="GPPerms\GPPermsServiceProvider" --tag="gpperms-migrations"
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
- ```rank_id``` = integer, will match what is in the gpperms_ranks table
- ```added``` = Big integer, unix time of when the user was added to the database
- ```updated``` = Big int, unix time of when the user's rank was changed

``gpperms_ranks``
- ```rank_id``` = auto increment integer of rank id
- ```rank_name``` = string, name of the rank

## Usage
```php
use GPPerms;
// User MUST be logged in and set in the database to the right rank
if (GPPerms::CanDo('Rank Name or Rank ID')) {
	// code here if approved
}
if (GPPerms::CanDo('Admin') || GPPerms::CanDo('SysOps')) {
	// code here if approved
}
// use this to give users a rank
$returnedstring = GPPerms::AddorUpdateUser($user->id, "Rank Name or ID");
var_dump($returnedstring); // will say what has happened

$rank_id = GPPerms::AddorUpdateRankName($rank_name, $optional_id);
// $optional_id is ONLY for updating, can be empty for making a new rank unless rank_id is NOT auto incremented
$rank_id = GPPerms::AddorUpdateRankName($rank_name);

$rank_name = GPPerms::GetRankName($rank_id);
```