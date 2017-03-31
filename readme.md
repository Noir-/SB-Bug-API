# Speedblocks bug report backend

This is a micro service implemented in Laravel Lumen. It offers a simple API for adding and reviewing bug reports. It is meant to be used withing the Speedblocks game client. At the moment there is no authentication required for adding a new bug report to make it as simple as possible for users to contribute to the project.

## Requirements
This project is build with Laravel Lumen. You can find the requirements of the framework [here](https://lumen.laravel.com/docs).
It is also required to install composer, a PHP package manager. Instructions for this can be found [here](https://getcomposer.org/download/)

## Installation

1. Clone this repository
2. Install dependencies `composer install`
3. Copy the `.env.example` to `.env` to create a global configuration storage and modify the `DB_` variables to match your configuration
4. The lumen framework uses memcached as cache driver. For testing I recommend using `CACHE_DRIVER=file` instead.
5. [Optional] Deploy the project to the http root of your web server and configure the web server so that the http root points to the `public` directory of this project
6. Create the database tables by running `php artisan migrate`
7. [Optional] To seed the database with some example data run `php artisan db:seed`

## Usage

At the moment there are two routes configured. To view all reported bugs point your browser to `/bugs/view`. There you need to specify a API key to query data. After adding the key press the button next to the text field to refresh the table. This can also be done to update the existing data.

The data is queried via HTTP GET from `/bugs`. This endpoint checks for a `x-api-key` HTTP header field and looks up the value within the `api_key` column in the `Users` table. If there's no match, it returns th HTTP status code `401`.

For direct and comfortable communication with the API you can use tools like the Postman addon for Chromium based browsers or HTTP-Requester or Firefox. Alternatively search the extension repository of your browser vendor for things like REST client.

## Contribution

Please note that I can not give you extensive support for the Laravel Lumen framework. Please refer the documentation or search the internet for questions about implementing things in Lumen.

If you have a question about implementation details, feel free to open an issue so that we can discus it.

Below you can find a list with things which have to be done. It's ordered by priority.

## ToDo

- Add some tests
- Migrate to Eleoquent ORM
- Add bug deletion functionality
- Add bug edit functionality
- Add GitHub API functionality to create issues from bug reports
- Add pagination to the `/bugs` endpoint

## License

This API backend is open-sourced software licensed under the [LGPLv3 license](https://opensource.org/licenses/LGPL-3.0)
