# Logging

More often than not, logging is an afterthought. I've usually seen it added (including by me) long after the application has launched in an effort to track down some new bug. And in those cases we kick ourselves for not having implemented logging in the first place. Maybe we should take our own advice and actually start logging from the outset.

### Laravel's default logging

Thankfully, Laravel is helpful. Pretty much every error it catches gets added to a log file. All we have to do is look in `~/storage/logs` and have a poke around. Of course, Laravel can't record logs for errors that stop Laravel from working at all, so some of the more serious errors will be lost - hopefully your server environment will have its own logs, but there's not guarantee of that.

### Not just for errors

Logging isn't only useful for errors though. It's also useful for recording when things go right. For example, I have an application that logs each time a user logs in, just so I can monitor that more easily. There are different levels of log too:

* Emergency
* Alert
* Critical
* Error
* Warning
* Notice
* Info
* Debug

You could easily add logs for successful actions, so that you at least have a record that something is happening.

```php
Log::info('User someone@somewhere.com tried to log in with incorrect password');
```

### GDPR

Oh, hang on, logs still count as data. That means we need to be careful what we're actually storing, and for how long. For starters, it's a good idea not to store actual personal information in a log message, just in case someone got hold of the logs. For the example above, if the person is already registered then we could store the user ID instead of the email address; that way it would only be a risk if someone got hold of the database as well (which would be a whole other set of concerns).

```php
Log::info('User ' . $user_id . ' tried to log in with incorrect password');
```

We also need to think about data cleansing. There's no point hanging onto logs that are out of date and irrelevant. Thankfully Laravel (in the current version at least) automatically splits errors into daily files and only keeps up to 14 of them; logs older than 14 days old are automatically deleted.

### More data

If you're including data in the log, note that you don't have to include it in the message itself. You can pass a whole array of data as a second parameter. This keeps things tidier.

```php
Log::info('Login failed', ['user_id' => $user_id]);
```

### Moooaarr data

I often find myself wishing for better logs when a user gets an error message I wasn't expecting. I usually have to ask them "what were you doing at the time?" Their response is often "I was using the site". Helpful.

What we could (should) do is make sure that the error log includes more information, such as what page was being requested, which user made the request, and what data was being submitted. We can extend the `context()` function in `~/app/Exceptions/Handler.php` to do this:

```php
protected function context()
{
    try {
        return array_filter([
            'url'     => Request::fullUrl(),
            'input'   => Request::except(['password', 'password_confirmation']),
            'user_id' => Auth::id() ?? null,
        ]);
    } catch (\Throwable $exception) {
        return [];
    }
}
```

Note that we're excluding password fields, because we don't want to be inadvertently storing those in plain text, even for 14 days! Applying `array_filter()` just removes any empty values.

By default, Laravel will catch form validation errors and automatically redirect back to the form with the errors. But we can catch those errors and log the faulty request too:

```php
public function store(Request $request)
{
    try {
        $comment = new Comment([
            'name'    => $request->get('name'),
            'email'   => $request->get('email'),
            'age'     => $request->get('age'),
            'comment' => $request->get('comment'),
        ]);
        $comment->save();
    } catch (ValidationException $exception) {
        Log::info('Comment submitted but invalid', [
            'data' => $request->except(['_token']), 
            'errors' => $exception->validator->errors()->toArray()
        ]);
        throw $exception;
    }

    return redirect(action('GuestBookController@index'));
}
```

This way, when someone calls you up and says "the website isn't working" you can see exactly what data they submitted and what the error message was, without having to ask them. Neat.

```
[2019-07-25 14:02:42] local.INFO: Comment submitted but invalid {"data":{"name":null,"email":null,"age":null,
"comment":null},"errors":{"name":["The name field is required."],"email":["The email field is required."],
"age":["The age field is required."],"comment":["The comment field is required."]}}
```

### Swimming in logs

The trouble with logs is not just saving them but interpreting them. By default, logs are stored in text format in a file, which can be troublesome to wade through, and almost impossible to aggregate. If you know this pain, consider using something like [Laravel Log-to-DB](https://github.com/danielme85/laravel-log-to-db) which, as the name suggests, saves your logs to a database table. It's probably a good idea to save the logs to a file as well, because if database access was the problem then you won't get any logs! Still, this approach means you can run queries on your logs far more easily. Just remember to clear out old logs somehow.
