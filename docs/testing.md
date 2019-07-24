# Testing

Before we get too far into a project, we need to think about testing. Test Driven Development (TDD) has been gaining in popularity, and it's generally accepted that testing is a good idea. Someone wise recently used the illustration of a car - you wouldn't buy a brand new car if it hadn't been tested. We web developers are making websites, some of which are similar in value, so we should expect our websites to be thoroughly tested too. Testing is a sign of trustworthiness.

But there's more to testing than just loading it up in a browser and declaring "yup, it works for me". Tests need to be repeatable and fast, which means they need to be automated so that a computer can do the testing for us. Testing also needs to avoid assumptions about what the data will look like, because what you have on your development environment isn't likely to be the same as on production.

## Back end unit testing

I'm not going to go into the details of how to use PHPUnit, but I am going to tell you to use it.

Unit tests should test specific 'units' of functionality. That means your code should be designed with testing in mind, with functionality sectioned off and individually testable. If it's not, that's arguably an immediate design problem. We need to avoid "god classes", where everything happens in one place, and instead split out our code into bite-sized chunks. That might mean refactoring your code, or thinking differently about how you write it in the first place, but it'll be worth it.

Data processing should happen in Models, not Controllers. And if you can put reusable functionality into shared traits or inherited classes, that's all the better from a testing perspective - write once, test once, use everywhere.

Don't forget to test for errors as well. It's great to know that given a certain set of inputs you get the right outputs, but just as important is to know that if the inputs are wrong that it's handled properly. You want to know that your code won't accept something silly, that exceptions are thrown at the right points and for the right reasons. You'll probably end up with more tests for errors than for successes, but that's fine - what we're aiming for is a guarantee not just that the site works but that the site *can't* break.

Laravel provides a quick and easy way of creating a new unit test:

```bash
php artisan make:test --unit ThingTest
```

That will generate a stub test in `~/tests/Unit/ThingTest.php`.

Here are some good things to test:

* Model validation
* Data transformation
* Appropriate exceptions are thrown

And to run all your tests:

```bash
phpunit
```

## API testing

This straddles front end and back end to some degree, in that these tests rely on HTTP requests to your application. Here, you're not testing units of code, but rather the final response. Take care not to test functionality that has already been unit tested elsewhere, but instead focus on what additional work the API itself is doing:

* Input handling
* Exceptions are handled gracefully
* Data format

```bash
php artisan make:test ThingsTest
```

This will create a stub test in `~/test/Feature/ThingsTest.php`.

## Javascript testing

If you're creating functionality in Javascript that could be considered "back-end", it's worth testing those too. [Jest](https://jestjs.io/) is a good framework for this.

## Front end testing

Putting it all together, we might want to do some "end-to-end" testing to ensure that all our different components work together. This is typically done by actually loading a web page in an actual browser and making sure it all works. There are a couple of options here, depending on your development environment.

[Laravel Dusk](https://laravel.com/docs/5.8/dusk) is a good option, extending PHPUnit and wrapping up some Laravel environment stuff to make it easy to set up test. If your development environment is virtualised, you may find that this requires your tests to run on a headless Chrome browser, which might not be exactly the same as what you've got on your desktop, so there are some things to watch out for there. But you'll be able to check that certain HTML markup is present, that Javascript interaction works, that kind of thing.

If that doesn't work for you then [Cypress](https://www.cypress.io/) is worth a look. This can run on your host machine, opening a local browser and doing all the tests from there. You can achieve much the same as Laravel Dusk, though without direct access to the Laravel underpinnings.

## When to write tests?

As soon as possible. Ideally, you should be writing your tests alongside the development of the feature it's testing. If nothing else, it gives you a way to check that what you're creating actually works, before you plug it into your application. For example, let's say you're creating a new Eloquent Model; you should write the tests for all the functionality that Model will provide (outside of what Eloquent itself gives you) and test it thoroughly BEFORE you actually start using it in a Controller.

That works for unit tests (including Javascript unit tests), but for front-end testing you'll have to wait until the application is created and working, otherwise you'll have nothing to test.

## When to test?

Unit tests generally run a lot faster than API tests or front-end tests, simply because they are testing raw PHP functionality, and shouldn't be accessing the database or requiring HTTP requests (in most cases). You can (and should) safely run your unit tests all the time during your development. You should *definitely* run all the unit tests before committing anything to your Git repo.

More time-heavy end-to-end tests can be run less often, but they're still important. I'd recommend running them before and after a Git merge, for example, and definitely before deployment.
