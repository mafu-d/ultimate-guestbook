# How to make the ultimate guestbook

I know what you're thinking. Guestbooks are so 1990. Yawn. Who uses those?

And you're right, the concept of a guestbook is pretty outdated by today's standards. But the premise of it - the idea that a visitor to your website can leave a comment - is just comprehensive enough to be a useful project to showcase some best practice, without getting bogged down in the functionality itself. So, what follows is my opinion* of what a guestbook project could look like in 2019.

\* I am entitled to my own opinion, as are you. I accept that I may be wrong; please be gracious in your judgement of me. Be advised that my opinion may change or become outdated.

## The project plan

### Objectives

* Show a list of previous messages in chronological order
* Allow public visitors to type a new message

### Scope

I shall assume that the site will be hosted on a LAMP stack (current as of 2019), but the hosting specifics themselves are out of scope for this project.

I will assume that you have basic knowledge of PHP, Javascript and Git, and are comfortable using a Linux-like terminal (GitBash on Windows may suffice).

### Best practices to explore

The purpose of this project is not so much the website itself (which will undoubtedly be ugly), but the process we'll go through to get there. My intention is not just to show you what an ultimate guestbook would look like, but to demonstrate techniques you might find useful in your own projects. As such, we'll be looking at the following topics:

* [Laravel - why it's awesome](docs/laravel.md)
* [Seeding for development](docs/seeding.md)
* Blade templates
* Resource controllers
* Value objects
* Model validation
* Laravel Mix
* PHPUnit - back end unit testing
* Cypress - end to end testing
* Documentation
* PHP Code Sniffer
* Git hooks
* Deployment
* Logging
