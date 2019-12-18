<?php

use Illuminate\Database\Seeder;

class ContactsTableSeeder extends Seeder
{
    
    public function run()
    {
        DB::table('contacts')->insert([
            'name'    => Str::random(10),
            'email'   => Str::random(10).'@gmail.com',
            'phone'   => '01' . rand(100000000 , 999999999) ,
            'subject' => Str::random(20) ,
            'message' => Str::random(500) , 
            'created_at' => date("Y/m/d")
        ]);
    }
}
