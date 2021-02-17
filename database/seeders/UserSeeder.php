<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dataUsers = array(
            '1' => array(
                'email' => 'joe@gmail.com',
                'password' => 'joe123',
                'phone' => '082227126670',
                'firstName' => 'Joe',
                'lastName' => 'Widjaja',
                'photo' => env('APP_URL') . '/storage/app/images/profiles/person1.png'
            ),
            
            '2' => array(
                'email' => 'abdul@yahoo.co.id',
                'password' => 'abdul123',
                'phone' => '082227129870',
                'firstName' => 'Abdul',
                'lastName' => 'Bakri',
                'photo' => env('APP_URL') . '/storage/app/images/profiles/person2.png'
            ),
            '3' => array(
                'email' => 'veron@gmail.co.id',
                'password' => 'veron123',
                'phone' => '082223769870',
                'firstName' => 'Veronica',
                'lastName' => 'Natalie',
                'photo' => env('APP_URL') . '/storage/app/images/profiles/person3.png'
            )
        );

        foreach ($dataUsers as $item => $val) {
            DB::table('users')->insert([
                'email' => $val['email'],
                'password' => $val['password'],
                'phone' => $val['phone'],
                'first_name' => $val['firstName'],
                'last_name' => $val['lastName'],
                'photo' => $val['photo']
            ]);
        }
    }
}
