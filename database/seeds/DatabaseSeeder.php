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
        \App\User::updateOrCreate(
            ['email' => 'user@user.com'],
            [
                'name' => 'user',
                'email' => 'user@user.com',
                'password' => '12345678',
            ]
        );

        $products = ['Chrombook','Samsung Mobile', 'Macbook'];

        foreach ($products as $key => $product){
            \App\Product::updateOrCreate(
                ['name' => $product],
                [
                    'name' => $product,
                    'description' => 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using  making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for  will uncover many web sites still in their infancy.',
                    'price' => ($key+1)*50,
                ]
            );
        }
    }
}
