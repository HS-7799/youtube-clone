<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $user1 = Factory(App\User::class)->create(['name' => 'hamza elharsi','email' => 'hamza@example.com']);
        $user1->channel()->create([
            'name' => $user1->name,
            'description' => $user1->name.' channel',
        ]);

        $user2 = Factory(App\User::class)->create(['name' => 'houssam elharsi','email' => 'houssam@example.com']);
        $user2->channel()->create([
            'name' => $user2->name,
            'description' => $user2->name.' channel',
        ]);

        Factory(App\Channel::class,30)->create(); // creation of 30 channles with their owner


        //   subscriptions
        $users = App\User::all();
        $users->each(function($user){ return $user->subscribe(App\Channel::all()->random()); });

        //videos
        Factory(App\Video::class,60)->create();

        //comments
        Factory(App\Comment::class,1000)->create();

        //replies on comments

        for($i = 0;$i<3;$i++)
        {
            Factory(App\Comment::class,50)->create([
                'comment_id' => App\Comment::all()->random()->id
            ]);
        }


    }
}
