<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        Artisan::call( 'lacc:make-permissions' );
        // $this->call(UsersTableSeeder::class);

        Schema::enableForeignKeyConstraints();
    }
}
