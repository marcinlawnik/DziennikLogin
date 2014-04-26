<?php

class UsersTableSeeder extends Seeder {

    public function run()
    {
        User::create(array(
            'firstname' => 'Marcin',
            'lastname' => 'Lawniczak',
            'email' => 'marcin.safmb@gmail.com',
            'password' => '$2y$10$d61z7FgmIwJ87dRUAbfE5ekd.Qf.pQQrORGAKD.ce3tKO0G8NI9.G',
            'registerusername' => 'marcin.lll',
            'registerpassword' => 'eyJpdiI6Im1oTTRnVk9iamJUUkkyN2g3blwvSFJrXC9HSG0zMkdQMmRGc29GTHdWSUxqQT0iLCJ2YWx1ZSI6IlVzOXVqUmRjYUx0a0xCdFZ1UlZ1OXltaXkwSHVEK3dQRXFMU0p2ZFMzUVE9IiwibWFjIjoiZmQyYjIxNWRlNzA5Njc3MDZkZDE1ODU3NGViNGM1NTNlYjJmOGRlZThlNzFkNWVmMTllMWQzOGY3NmFiZjA2ZCJ9',

        ));
    }
}