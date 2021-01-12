# MiniAspire

A simple API for loan application, please refer the cover features at here 

**[Features](https://github.com/kientrunghuynh/miniaspire/blob/master/Features.md)**

These are lacking some features like:
- The API protection which we can Laravel's packages like [Passport](https://github.com/laravel/passport) or [Sanctum](https://github.com/laravel/sanctum) depend on our expectation
- Dockerize application which we can use the [Sail](https://github.com/laravel/sail) (we write docker-compose and dockerfile also )
- API document which we can use the [DarkaOnLine/L5-Swagger](https://github.com/DarkaOnLine/L5-Swagger)
- Monitor && Auding the modes changes which we can use [Accountant](https://altek.gitlab.io/accountant/installation.html#version-matrix)

## Getting Started

Please follow below instruction to get this project running on your local development.

### Prerequisites

* [Composer](https://getcomposer.org/doc/00-intro.md)
* \>= PHP 7.3

### Installing

Please run the following commands to setup your development env up.

```bash
# clone this repository
git clone https://github.com/kientrunghuynh/miniaspire.git

# change directory
cd miniaspire/

# install the project's dependencies using Composer
composer install

# make a copy of the .env.example to configure the application 
# for your local environment
cp .env.example .env
```

**Update your `.env` file with appropriate values for your database, cache, mail, etc,**

```bash
# run the migrations together with the seeders to setup the database
php artisan migrate --seed
```

### Running the application

If your development environment is set up using [Homestead](https://laravel.com/docs/5.5/homestead) or [Valet](https://laravel.com/docs/5.5/valet), please follow the guides that come with your chosen tool. 

Otherwise, you can use the development server the ships with Laravel by running, from the project root:

```bash
php artisan serve
```
You can visit [http://localhot:8000](http://localhot:8000) to see the application in action.

## Running the tests

There are tests for some Controllers, Jobs, Models available in the `tests/` directory.

```bash
# to run all tests
./vendor/bin/phpunit
```

## Built With

* [Laravel](https://laravel.com) - The web framework used

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details
