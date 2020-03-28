# ChemLab

Simple chemical inventory management

- [Laravel](https://laravel.com) backend
- [Vue.js](https://vuejs.org) frontend

## Requirements
- Server - PHP 7.2.5
- Database - MySQL (tested), or any Eloquent ORM supported driver
- refer to Laravel docs for detailed requirements 

## Installation
- read [Laravel docs](https://laravel.com/docs) how to deploy Laravel-based application

#### Backend
- Install backend dependencies
```shell script
composer install
```

- create new .env file
```shell script
cp .env.example .env
```

- generate app key
```shell script
php artisan key:generate
```

- run migration
```shell script
php artisan migrate:fresh --seed
```

- update .env with necessary configuration
- additional configuration files are in `config` folder
- refer to [Laravel docs](https://laravel.com/docs) for any further configuration 

#### Frontend

- Install frontend dependencies
```shell script
npm install
```

- Prepare locale files
```shell script
npm run locales
```

- Build frontend app
```shell script
npm run prod
```

## License

ChemLab is open-source software licensed under the [MIT license](https://opensource.org/licenses/MIT).
