<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        collect(factory(\App\Models\User::class, 25)->create())
            ->each(function ($user) {
                collect(factory(\App\Models\Post::class, 50)->create(['user_id' => $user->id]))
                    ->each(function ($post) {
                        collect(factory(\App\Models\Comment::class, rand(5, 10))->create([
                            'post_id' => $post->id,
                            'user_id' => rand(1, 25),
                        ]));
                    });
            });
    }
}
