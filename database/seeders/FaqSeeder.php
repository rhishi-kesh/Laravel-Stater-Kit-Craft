<?php

namespace Database\Seeders;

use App\Models\Faq;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Faq::insert([
            [
                'question' => '1. What is Laravel, and why should I use it?',
                'answer' => 'Laravel is a PHP framework designed for building modern web applications. It offers an elegant syntax, built-in authentication, database migrations, and a powerful ORM called Eloquent, making development faster and more efficient.',
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'question' => '2. How do I install Laravel?',
                'answer' => 'You can install Laravel via Composer using the command: `composer create-project laravel/laravel project-name` or `laravel new project-name` if you have the Laravel Installer installed.',
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'question' => '3. What is Eloquent ORM in Laravel?',
                'answer' => 'Eloquent is Laravel’s built-in ORM (Object-Relational Mapper) that allows you to interact with your database using an expressive and fluent syntax instead of writing raw SQL queries.',
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'question' => '4. How do I create a migration in Laravel?',
                'answer' => 'You can create a migration using the Artisan command: `php artisan make:migration create_table_name_table`. Then, define your schema inside the generated migration file and run `php artisan migrate` to apply the changes.',
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'question' => '5. How do I use Middleware in Laravel?',
                'answer' => 'Middleware filters incoming HTTP requests. You can create middleware using `php artisan make:middleware MiddlewareName`, define your logic in the handle method, and register it in `app/Http/Kernel.php`.',
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'question' => '6. How do I implement authentication in Laravel?',
                'answer' => 'Laravel provides built-in authentication using Breeze, Jetstream, or the classic `php artisan make:auth` in older versions. You can set up authentication using `composer require laravel/breeze` and running `php artisan breeze:install`.',
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
