# Model validation

All data is not equal.

When dealing with data in your application, we need to ensure it's valid. Often, validation is done at the controller level, so that the information the user has submitted is checked before it's stored. That's fine, but it misses the case where the data might be changed by your application. We don't just want our incoming form data to be valid, we want our *model* to be valid, at all times.

## Validating trait

I really love [Dwight Watson's Validating trait](https://github.com/dwightwatson/validating). This is a great little library that allows us to define our validation rules at the model level, allowing us to ensure our model is always valid. Let's install it:

```bash
composer require watson/validating
```

Now let's put it into our Comment model and define some validation rules:

```php
<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Watson\Validating\ValidatingTrait;

class Comment extends Model
{
    use ValidatingTrait;

    protected $throwValidationExceptions = true;

    protected $rules = [
        'name'    => ['required', 'string', 'max:191'],
        'email'   => ['required', 'email', 'max:191'],
        'comment' => ['required', 'string'],
    ];
}
```

That `$throwValidationExceptions` flag tells the Validation trait to throw an exception if the rules are not satisfied when your application tries to `save()`. Laravel's exception handling is generally excellent, so this works a treat.

## Value objects

But wait! How do we know that the 'name' actually looks like a name? Sure, we could potentially add custom validation rules into the model to define what a name looks like, or an email address, or a street address, or what have you, but there must be a better way? Surely?

Yep, that's where Value Objects come in. These are small classes that define a single 'piece' of data and ensure that it's always valid. You could think of it like a miniature model, but without the database.

Let's start by extending the concept of our 'comment' to require an age. Let's imagine that we only want adults to leave comments. Our form would ask for an age as a number, and in our database we'd store it as an integer, but there's more to an age than that - it can't be less than zero. In our specific case, we actually want a minimum age of 18, and we'd probably want a maximum age too (not because we're ageist, but to stop people pretending they're 200). And it doesn't make sense to perform mathematical operations on ages, so it ought to be read-only (immutable).

To help create value object in a consistent way, I'm using the following:

```bash
composer require funeralzone/valueobjects
```

Let's create a new class called `~/app/ValueObjects/Age.php`:

```php
<?php declare(strict_types=1);

namespace App\ValueObjects;

use Funeralzone\ValueObjects\Scalars\IntegerTrait;
use Funeralzone\ValueObjects\ValueObject;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

final class Age implements ValueObject
{
    use IntegerTrait;

    /**
     * Age constructor.
     *
     * @param $age
     *
     * @throws ValidationException
     */
    public function __construct($age)
    {
        Validator::validate(['age' => $age],
            ['age' => ['required', 'integer', 'gte:18', 'lte:120']]
        );
        $this->value = $age;
    }
}
```

See how the validation of an age is defined within the value object itself? That makes it reusable across your application. If you try to make an age with an invalid value, it will throw an exception.

Now we need to hook it up to the model validation we set up earlier. To do this in a repeatable way, we can create a Rule Object to dynamically check the validity of an attribute against a particular value object. Look at `~/app/Rules/ValueObject.php` to see how that's done. We only need to do that once, and now in our Comment class we can hook it into the validation rules:

```php
$this->rules = [
    'name'    => ['required', 'string', 'max:191'],
    'email'   => ['required', 'email', 'max:191'],
    'age'     => ['required', new \App\Rules\ValueObject(Age::class)],
    'comment' => ['required', 'string'],
];
```

The value we pass to the Comment model will start out as a number. When we set `$comment->age` to that number it is stored natively in the same format we provided it in, but the model won't save unless it validates. During that validation process we check that the value can be successfully saved as an `Age` value object, which is where its own validation rules take effect. If everything checks out, the value is saved in the database as an integer.

When we later want to use the age, we have two options. First, we can use the raw value, as we would normally with an Eloquent model, by directly accessing `$comment->age`. However, we can also add a method to the Comment class that will wrap the value in an `Age` value object. Now we can use `$comment->age()` to get the value object; if we do that we could imagine adding further methods to the value object class to do things like formatting.

```php
public function age()
{
    return new Age($this->age);
}
```
