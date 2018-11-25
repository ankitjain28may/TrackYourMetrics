# Track Your Metrics (File Management)

A web application which would let the users to create folders, upload files,
list all the files, folders and search for the files.

>Note: The website is deployed to heroku [http://track-your-metrics.herokuapp.com](http://track-your-metrics.herokuapp.com) So any folders/files created will be removed after a while as heroku doesn't allow to save data to disk space.

## Installation and Contribution

### Requirements :

1. PHP >= 7.1
2. MySQL >= 5.7
3. Composer
4. Laravel == 5.7.*
5. HTML, CSS, JS (Laravel Blading)

### Completed Tasks :

* [x] Encrypt files while uploading.
* [x] There should also be option for decrypting files (Show the decrypted file in
the system).
* [x] Implement search feature (basic file name search).
* [x] Visually interactive responsive design listing all folders and files.
* [x] Implement login and signup functionality.
* [x] Download File (decrypted).

### Bonus Tasks :
* [x] Download folders.
* [ ] Google Drive Integration (Store files in Google Drive)

### Usage :

1. Login/Register to website
2. Once you login/register you will be redirected to the dashboard where you can manage the files/folder.
3. Upload the files from the `cloud-upload` icon at the top left corner of the website.
4. To search or create new folder, hover/click on `settings` icon at the top right corner of the website.
5. You can switch to directories from left sidebar or breadcrumb navigation.
6. You can download files and folders (folders zip)

### Project Setup :

Fork and Clone this repo or download it on your local system.

Open composer and run this given command.

```shell
composer install
composer update
```

After installing composer, Rename the file `.env.example` to `.env`.

```shell
cp .env.example .env
```

> Set db credentials in `.env` and run the following Commands.

Generate the Application key

```php
php artisan key:generate
```

Migrate the database for auth scaffolding provided by laravel.

```php
php artisan migrate
```

> Run this project on localhost

```php
php artisan serve
```

This project will run on this server:

```shell
http://localhost:8000/
```

### Contribution

1. Fork and clone the repo.
2. Follow the installation procedure to make it run on your local system.
3. Open an issue for adding any feature or to resolve any bug.
4. Make your own branch and send pull request to that branch.
