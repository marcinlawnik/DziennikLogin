<?php

class UsersDemoSeeder extends Seeder
{
    public function run()
    {
        Sentry::register([
            'email' => 'test@test.com',
            'password' => 'test',
            'registerusername' => 'testregister',
            'registerpassword' => Crypt::encrypt('testregister'),
            'job_is_active' => 1,
            'job_interval' => 15
        ], true);

        Sentry::register([
            'email' => 'admin@test.com',
            'password' => 'test',
            'registerusername' => 'testadminregister',
            'registerpassword' => Crypt::encrypt('testadminregister'),
            'job_is_active' => 1,
            'job_interval' => 15
        ], true);
    }
}
