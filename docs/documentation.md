# Documentation

Documentation is something you do at the end of the project, once it's all done, right? WRONG.

The last thing you want to be doing at the end of a project is trying to remember what a piece of code does. And if you're working with other people, it's even more important to be clear about what's going on and why. So it's good practice to make your code self-documenting *as you code it*.

## DocBlocks

A DocBlock is a multi-line comment that follows a particular structure.

```php
/**
 * This is the summary
 *
 * This is the description, if you need to add more detail 
 */
```

Depending on the context, you may also want to include various [tags](https://docs.phpdoc.org/guides/docblocks.html#tags) too.

### File summary

Some might consider this optional, but it's probably good practice to include a DocBlock right at the top of the file to describe the file as a whole. You may be able to get your IDE to auto-generate this for you when files are made.

```php
/**
 * filename.php
 * Created by Joe Bloggs on XXXX-XX-XX
 */
```

Note: there's a strong argument that if a file contains a class DocBlock it doesn't also need a file DocBlock.

### Classes

Each class should have its own DocBlock, describing its purpose and scope. This is also a good place to add tags for the properties you want to draw attention to (a good IDE will use this for type hinting too). For example, let's look at our Comment class:

```php
<?php

namespace App;

use Whatever;

/**
 * Comment class
 * 
 * Handles everything to do with a Comment
 * 
 * @author Joe Bloggs
 * @copyright 2019 My Company
 *
 * @property string $name
 * @property string $email
 * @property int $age
 * @property string $comment 
 */
```

### Functions

Each function should also start with a DocBlock, describing roughly what it does. It's useful to include tags here relating to what parameters can be passed to it, what it returns, and any exceptions that could be thrown. Again, a good IDE will help you fill these in.

```php
/**
 * Add two numbers together
 *
 * @param integer $first
 * @param integer $second
 * @return integer
 * @throws Exception
 */
public function addNumbers ($first, $second)
{
    // Code goes here
    
    return $result;
}
```

Another good practice you can use in functions is to specify the variable types, so that you'll never be in any doubt what sort of data you're dealing with. For example:

```php
public function doSomething (Email $email, string $name) : bool
{
    //
}
```

### Variables

For starters, it's good to add comments to show what sort of data each variable is going to contain. This also protects against reusing variables for different purposes in the same bit of code! IDEs will be able to type hint using these comments too. You don't necessarily need to do this for every single variable, but certainly for variables that you'll be using a lot or where the name itself doesn't give you all the clarity you need. Notice how we can specify the type and also provide a description of what the data represents.

```php
/** @var int $years The number of years in the target range */
$years = 3;
```

### Data transformation

Sometimes, your code does something complicated. A bit of formatting goes a long way, but sometimes it's just not clear what a piece of code achieves. Adding a comment inline will help explain to other developers (and you, when you look at it several months later) what the code does.

## Automating documentation

Documenting the code is great, but it does require developers to wade through your code to get to it. Thankfully, there are tools you can use that will automatically parse all your code and extract the comments, building a web-based report that's easy to navigate.

[PHPDocumentor](https://phpdoc.org/) is a good example. At the moment it won't install alongside Laravel using Composer, so you'll need to download the .phar file, but run that and it will generate documentation based on your DocBlocks.

```bash
./phpDocumentor.phar -d ./app -t ./docs/phpdoc
```

One thing to note: I generally exclude generated content from my Git repo, so you won't find generated documentation in there either.
