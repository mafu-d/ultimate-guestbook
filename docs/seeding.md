# Seeding for development

Here is an important principle when developing - your production data is sacred, and your development data is disposable.

You obviously can't develop your application without any data at all, but what you need during development won't be the same as what you'll expect on production. When developing you'll want to cover as many use-cases as possible, but without the data actually being 'real'. And since you may (will definitely) make mistakes, you need to assume that your local database is temporary. If you accidentally (or deliberately) delete your local database, it should be trivial to rebuild it, without stress. That's where seeding comes in.

## Creating the database

Let's create our database. Laravel handles database changes using Migrations. Let's make a new one:

```bash
php artisan make:migration CreateCommentsTable
```

Laravel helpfully stubs out our file at `~/database/migrations/XXXX_XX_XX_create_comments_table.php`. Notice how it recognises some of the words in your class name and guesses what you want to do. In our case it's automatically assumed we're creating a new database table, named it, and added some default columns. We want to add to that with our own columns:

```php
<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('name');
            $table->string('email');
            $table->text('comment');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
```

Now we can run the migration:

```bash
php artisan migrate
```

Boom. Now we have a database table for our visitors' comments. Next we'll want to populate it with some example data.

Let's start by creating a model, which is a class that connects our code to the database table:

```bash
php artisan make:model Comment
```

That gives us `~/app/Comment.php`. Note the capitalisation and pluralisation as we go through all these steps.

A useful feature of Laravel is Factories, which allow us to generate 'fake' records quickly and easily based on some assumptions. The factory churns out as many records as we want.

```bash
php artisan make:factory CommentFactory
```

That gives us `~/database/factories/CommentFactory.php`. This is where we tell Laravel what information to put into a fake Comment:

```php
<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Comment;
use Faker\Generator as Faker;

$factory->define(Comment::class, function (Faker $faker) {
    return [
        'name'    => $faker->name,
        'email'   => $faker->email,
        'comment' => implode("\n", $faker->paragraphs(2)),
    ];
});

```

We're using the awesome `$faker` object to choose some appropriate random data to populate each comment. Now we can create a seeder:

```bash
php artisan make:seeder DevCommentSeeder
```

This creates `~/database/seeds/DevCommentSeeder.php`. We'll tell it that we want 5 comments.

```php
<?php

use App\Comment;
use Illuminate\Database\Seeder;

class DevCommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Comment::class, 5)->create();
    }
}
```

You might have several of these development seeders (which is why I prefix them with 'Dev'), so it's probably worthwhile creating a central development seeder that calls all the others.

```bash
php artisan make:seeder DevSeeder
```
```php
<?php

use Illuminate\Database\Seeder;

class DevSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(DevCommentSeeder::class);
    }
}
```

Now we can run our seeder:

```bash
php artisan db:seed --class=DevSeeder
```

Take a look in your database now and you'll see 5 new records filled with glorious test data.

## Summary

Did you follow what was happening there? Let's just recap:

1. We tell Laravel we want some development data.
2. `DevSeeder` calls `DevCommentSeeder`
3. `DevCommentSeeder` asks a factory to create 5 new comments and saves them in the database.
4. `CommentFactory` populates each comment with some example data.

Obviously you don't want this example data on production, which is why we separate it from the normal `DatabaseSeeder.php` file. We only want to run this on our development environment. But the beauty of it is that if we accidentally (or deliberately) delete our database we can quickly and easily rebuild it without having to manually add any data. It gives us a starting state for our application that we can always come back to if we make a mess of things.
