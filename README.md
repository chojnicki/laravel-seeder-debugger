# Laravel Seeder Debugger

Get simple debug info after finished seeding, like this:
```
Database seeding completed successfully.
Seeding execution time: 8.6s.
Database queries executed: 329.
Current RAM usage is 18.7MB with peak during execution 59.1MB.
```
Thanks to this info you can try to write more efficient seeders :)

Do you need more info in debug? Feedback and pull requests are welcome. 

## Requirements

- Laravel / Lumen 5.5 or higher (written on 5.8, not tested on lower than 5.5 but should work on 5.*)


## Instalation with Composer

```
composer require chojnicki/laravel-seeder-debugger
```



## Usage

In DatabaseSeeder.php simply replace:
```
use Illuminate\Database\Seeder;
```
with:
```
use Chojnicki\LaravelSeederDebugger\Seeder;
```

## Note
This debugger simply extends original Seeder library (is not a fork) so all functionality is preserved and there should not be conflicts with already written seeders.
