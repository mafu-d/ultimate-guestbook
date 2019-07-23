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
