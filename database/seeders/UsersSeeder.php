<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;



class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      for($i=0 ; $i< 10 ; $i++) {

        DB::table('users')->insert([
        	'name' =>"Amed$i",
        	'email' =>"Amed$i@gmail.com",
        	'password' =>bcrypt('0000'),

        	  ]) ;
    }

    }
}
