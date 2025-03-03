Prerequisites:
* Homebrew installed (if not, follow Homebrew installation guide).
* PHP 8.3.17 installed.
* MySQL  (or any other DB supported by Laravel).
* Composer installed.
  
Steps to Set Up Laravel with Passport Authentication

Step 1: Install Dependencies Using Homebrew
First, make sure your environment is set up correctly.
Install PHP (if needed):
If PHP isn't installed or you need to upgrade PHP to version 8.3, you can do so with Homebrew:

brew install php@8.3
brew link --overwrite --force php@8.3
Install Composer:
To manage PHP dependencies, you'll need Composer. If Composer isn't installed, you can install it via Homebrew:

brew install composer
Install MySQL:
If you plan to use MySQL as your database:

brew install mysql
brew services start mysql
This will install and start MySQL as a background service

brew install node

Step 2: clone  Laravel Project 

https://github.com/flerickdanthi/Astudio-laravel.git

cd <your-cloned-repository>

Step 3: Install Laravel Passport
Install Passport via Composer:
To install Passport, run the following:

composer require laravel/passport
Run Passport Migrations:
Passport needs a few database tables. Publish the necessary Passport migration files:


php artisan migrate
Publish Passport Assets:
You also need to publish the Passport configuration file:

php artisan passport:install
This command will generate the encryption keys needed for Passport and create personal access and password grant clients.

Step 4: Configure Laravel Passport
Set up .env file:
Add Passport-related environment variables in the .env file. Make sure to set the appropriate database connection for DB_ variables.

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_db_name
DB_USERNAME=your_db_user
DB_PASSWORD=your_db_password

APP_KEY=base64:your-app-key

Update config/auth.php:

In the config/auth.php file, set the driver for API authentication to passport:

'guards' => [
    'web' => [
        'driver' => 'session',
        'provider' => 'users',
    ],

    'api' => [
        'driver' => 'passport',
        'provider' => 'users',
    ],
],

'providers' => [
    'users' => [
        'driver' => 'eloquent',
        'model' => App\Models\User::class,
    ],
],

Add Passport service provider:
Open config/app.php and add the Passport service provider to the providers array:

'providers' => [
    // Other providers...
    Laravel\Passport\PassportServiceProvider::class,
],

php artisan migrate
php artisan db:seed


Step 5: Set Up Passport Routes and Middleware
In app/Providers/AuthServiceProvider.php, you need to include Passport's routes within the boot method:

use Laravel\Passport\Passport;

public function boot()
{
    $this->registerPolicies();
    Passport::routes();
}
Then, ensure the Passport middleware is available in the api middleware group in app/Http/Kernel.php:
php


'api' => [
    \Laravel\Passport\Http\Middleware\CreateFreshApiToken::class,
],

Step 6: Generate Passport Keys (If Not Done Yet)
If you haven’t already generated the Passport encryption keys, run the following command to generate them:

php artisan passport:install


Php artisan migrate
Php artisan db:seed

Composer dump-autoload

Run these commands:

php artisan config:cache                                    
php artisan cache:clear
php artisan optimize
