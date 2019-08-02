# Automating FTW

You know that thing you keep doing? It's time to automate it.

Automation is actually all around us. It has become so normal that we miss it a lot of the time, and take it for granted. Not that long ago, if you wanted to call someone on the telephone, you'd have to remember (or look up) the person's phone number and dial it in one digit at a time. But these days we just select the person we want from our address book and press the green button. The phone has automated the process. Back in the day, if we wanted to know whether we'd need to fill up the car before we reached our destination, we'd have to check the fuel gauge, know from experience how long it normally lasts, perhaps even do some calculations on a piece of paper, and probably look on a map to see where local petrol stations might be. These days, the car knows all that and does the calculations for you, telling you exactly how many miles of range are left, and (depending on how clever the car is) even tells you which petrol station is cheapest on your route and how to get there. It has automated the process.

If you've been using a PHP framework like Laravel, you've already been using automation. Instead of coding from scratch, we're using code that's already been written, saving us time and effort. You know those database migrations we wrote? That's automation. We've taken the hard work of writing MySQL queries and packaged it up in a single easy to use command. Win.

Let's find some more things to automate...

## Code generation

### Artisan

Sure, you could write code yourself, but in some cases we can get the computer to write it for us. Laravel's [Artisan](https://laravel.com/docs/5.8/artisan) tool can do a lot of cool things, including making various files for you. Need a new controller? Easy, just type `php artisan make:controller MyController` and it'll create the file in the correct place with some code to get you started. Need to make a new migration? Easy, just type `php artisan make:migration CreateEventsTable` and it'll create the migration file in the right place and even prepopulate the `up()` function with the commands to create a new table called `events`. It's well worth reading up on what else Artisan can do for you, as it'll save you time and prevent mistakes.

```bash
php artisan list
```

### Emmet

You can get your IDE or code editor to help you out too. A plugin I highly recommend, and which is often shipped with editors by default these days, is [Emmet](https://emmet.io/). It massively speeds up the creation of HTML and CSS. For example:

```
div>ul.thing>li*2
```

This expands to:

```html
<div>
  <ul class="thing">
    <li></li>
    <li></li>
  </ul>
</div>
```

There's much more it can do too, so check out the documentation and see how it can transform your coding experience.

## Running tools

If you've been following along in this series of articles, you'll have seen we've set up various tools to help make our project awesome, from static analysis to unit testing. It would be great if we could automate these too, so that they automatically run at the right times so we don't have to remember ourselves.

### NPM scripts

You can create shortcuts in `package.json` by adding commands to the `scripts` object. There are already a few set up in this project, so take a look if you haven't already. For example, here's one you might be familiar with if you've been using Laravel Mix:

```bash
yarn dev
```

This is a shortcut to launching Laravel Mix to compile your JS and CSS in development mode (i.e. without minification). You can add your own scripts too, if there are NPM scripts you run on a regular basis. You can even group them together so that one command can do a whole load of things.

### Composer scripts

Your `composer.json` file can do the same sort of thing as your `package.json` file, in that you can add to the `scripts` object with your own commands. For example, we could add the following:

```json
{
  "scripts": {
    "tidy": [
      "phpcbf",
      "phpcs",
      "php artisan code:analyse",
      "yarn stylelint",
      "yarn standard"
    ]
  }
}
``` 

Now we can run `composer tidy` and it will run all these tools for us, checking our code quality and formatting.

Where it gets more clever is that you can tap into the composer lifecycle itself. For example, we can add scripts so that after Composer finishes installing its dependencies it also does something else, like generating our site documentation, clearing the cache, running database migrations, running PHPUnit tests.

### Git hooks

This is where the real automation power comes in. There are a few steps you'll do at various points during development that are linked to what you're doing in Git. For example, before committing your code to the repo you want to make sure it's properly formatted. You can set up a Git hook to run `composer tidy` before committing, so you don't have to remember to do it yourself. You could also add a Git hook so that after checking out a branch it automatically installs the Composer and NPM dependencies and rebuilds your assets.

There is a caveat to this, though - Git will run its scripts on the same machine as itself. If, like many developers, you're using some sort of virtualisation for your development environment (such as Vagrant or Docker), you may not be able to take full advantage of Git hooks unless you do all your Git actions from the virtual machine itself rather than your local machine. You may find you need to change your workflow.

If Git hooks are the way you want to go, check out [composer-git-hooks](https://github.com/BrainMaestro/composer-git-hooks). This is a good way of ensuring that your Git hooks are specified in your code so that other developers can easily use them too.
