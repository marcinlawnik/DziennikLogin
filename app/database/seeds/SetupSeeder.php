<?php

class SetupSeeder extends Seeder
{
    public function run()
    {
        Sentry::register([
            'email' => 'admin@admin.pl',
            'password' => 'test',
            'registerusername' => 'test',
            'registerpassword' => Crypt::encrypt('test'),
            'job_is_active' => 0,
            'job_interval' => 0
        ], true);


        Sentry::createGroup(array(
            'name'        => 'superuser',
            'permissions' => array(
                'superuser' => 1,
            ),
        ));

        $adminGroup = Sentry::findGroupById(1);

        $user = Sentry::findUserByLogin('admin@admin.pl');
        $user->addGroup($adminGroup);
    }
}
