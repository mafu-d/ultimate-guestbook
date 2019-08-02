<?php

namespace Tests\Unit;

use App\Comment;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CommentTest extends TestCase
{
    public function testComment()
    {
        $comment = new Comment([
            'name' => 'test',
            'email' => 'test@test.com',
            'age' => 30,
            'comment' => 'test'
        ]);
        $this->assertTrue($comment->isValid());
    }

    public function testCommentFailsWhenDataIsInvalid()
    {
        $comment = new Comment([
            'name' => 'test',
            'email' => 'test@test.com',
            'age' => 17,
            'comment' => 'test'
        ]);
        $this->assertFalse($comment->isValid());

        $comment->age = 18;
        $this->assertTrue($comment->isValid());
        $comment->name = null;
        $this->assertFalse($comment->isValid());

        $comment->name = 'test';
        $this->assertTrue($comment->isValid());
        $comment->email = null;
        $this->assertFalse($comment->isValid());

        $comment->email = 'a@a';
        $this->assertFalse($comment->isValid());

        $comment->email = 'test@test.com';
        $this->assertTrue($comment->isValid());
        $comment->comment = null;
        $this->assertFalse($comment->isValid());
    }
}
