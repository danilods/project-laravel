<?php

use Illuminate\Database\Seeder;

class ProjectNoteTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        // \App\Project::truncate();
        factory(\App\Entities\ProjectNote::class, 50)->create();
    }
}
