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
