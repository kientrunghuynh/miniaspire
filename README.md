# MiniAspire

A simple API for loan application

## Features

**Customers management**
**As a** a member of [the development team](http://scrumguides.org/scrum-guide.html#team-dev),
**I want** clear context and goals **so that** I can work efficiently.

Scattering information in emails and other places makes it difficult to work collaboratively,
so I need all the relevant information within the relevant issue.


### Acceptance Criteria

1. I have clear Acceptance criteria [what a beautiful recursion].
1. I have to understand the logic of the mockups, more than the pixels used, so that we can optimize the code.

Please also note:

1. If a conversation about the issue I’m working on is happening,
the outcomes should be documented within that issue (not in the comments).


### Resources:

* [Style-guides and template for a user story](agile-user-story.md)
* [“Advantages of the “As a user, I want” user story template.”](http://www.mountaingoatsoftware.com/blog/advantages-of-the-as-a-user-i-want-user-story-template)
* [Scrum guide](http://scrumguides.org/scrum-guide.html)

**Loans management**

**Loan Repayment management**



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
