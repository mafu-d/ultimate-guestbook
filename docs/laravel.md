# Laravel - why it's awesome

Once upon a time, websites were created in HTML using Notepad.exe. Files were moved around using FTP. Those were painful times.

As the web evolved and matured, people realised that things would be so much better if they were automated - where the computer did more work than the people using them. Various PHP frameworks were thrown around, and we realised that reusing code made development much faster, although with the trade-off that we didn't know (or necessarily trust) where all the code came from.

Laravel blew me away from the moment I set eyes on it. It was beautifully, achingly clean. Everything was easy, but at the same time everything was customisable. And because it was based on an established collection of underlying libraries, it was stable and reliable. Today, Laravel is probably the most widely used PHP framework out there, and for good reason.

## Installing Laravel

Ah yes, back to the project at hand. Let's make a guestbook.

We start off by creating a new Laravel project. There are various ways of doing this, but I generally fall back to using Composer.

```bash
composer create-project laravel/laravel guestbook
```

We should now have a blank Laravel project installed in a folder called 'guestbook'. I'll leave you to sort out your own development environment, essentially you need to accomplish the following:

* Direct your webserver to `guestbook/public`
* Point a domain at it

For the purpose of this demonstration, I'm going to assume that we've set up https://guestbook.local. And from this point on, I'm going to assume that our guestbook directory is our project root, and will refer to it as `~`. Load up the site, and you should see the default Laravel home page.

## Making ourselves at home

It's great to see that Laravel is working, but our project isn't a Laravel landing page, so let's start by getting rid of that.

Laravel makes use of the "Model, View, Controller" methodology of separating out the different parts of our code. There are other bits too, but let's start with MVC and go from there.

### Views

Views are how information is presented to the user. They shouldn't be about data or processing - we'll deal with that elsewhere. Views are templates into which data is inserted. Laravel looks for its templates in `~/resources/views`. If you like, you can just create an HTML file in there, or a PHP file, or a Twig file, or (and we'll come onto this presently) a Blade file. Either way, this is what determines the HTML markup of our site.

If you take a look in our views folder, you'll notice there is already a template there. That's what's creating our default Laravel landing page. Let's get rid of that for now, and create our own file. Since we'll be using Blade later on, let's create a file called `index.blade.php` and put some really basic HTML markup in it.

```php
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Guestbook</title>
</head>
<body>
    <h1>Guestbook</h1>
    <p>Hello world!</p>
</body>
</html>
```

You'd struggle to get more basic than that. But it's enough for now.

### Controllers

Now we want some way of processing some data and sending it to the user. That's where a controller comes in. It's essentially a class with various functions that encapsulate a group of related functionalities. In our case, let's start with a really simple controller that will serve up our guestbook. To make things easy for us, we can use Laravel's Artisan command line tool to create it for us:

```bash
php artisan make:controller GuestBookController
```

Now we've got a controller in `~/app/Http/Controllers/GuestBookController.php`. We just need one function for now, to display our guestbook home page, which we generally refer to as the index.

```php
<?php

namespace App\Http\Controllers;

class GuestBookController extends Controller
{
    public function index()
    {
        // Here is where we join the dots and send the result to the browser
    }
}
```

At the moment there is no data processing to do, so let's just return the template we made:

```php
public function index()
{
    return view('index')
}
```

That tells Laravel to look for a template called `index.blade.php` (it adds the rest of the filename itself) and return it to the browser. Again, it doesn't get much simpler than that.

### Routing

Now we want to hook our controller up to a URI so we can actually get to it. Our web routes are defined in `~/routes/web.php`, so let's open that up, remove whatever Laravel gave us to begin with, and put in our first route:

```php
<?php

Route::get('/', 'GuestBookController@index');
```

Now we can open up our website and we should get our template rendered to the browser!

## Hang on, where's the guestbook?

I'm guessing if you were interested in this series you may well already be familiar with Laravel, or at least how to make applications using PHP. You'll have noticed that the steps above haven't really achieved very much so far. Be patient, it'll happen.

What I DO want to talk about though is why I choose Laravel every time. Quite simply, it's quite simple. It's well organised and a genuine pleasure to use. It uses relatively easy to read language and naming conventions, so you know what things do. Sure, there are other frameworks out there you could look at, including Symfony, Slim Framework, CodeIgniter... do some googling and you'll find plenty. But I find Laravel a great choice for a wide range of applications, and familiarity means I don't have to keep learning new frameworks all the time. You can keep things really simple, like what I've done above, or you can make things really complicated - it's entirely up to you. And that, I think, is what makes a great framework.
