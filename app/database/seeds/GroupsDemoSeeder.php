<?php

class GroupsDemoSeeder extends Seeder
{
    public function run()
    {
        Sentry::createGroup(array(
            'name'        => 'Admins',
            'permissions' => array(
                'superuser' => 1,
            ),
        ));

        $adminGroup = Sentry::findGroupById(1);

        $user = Sentry::findUserByLogin('admin@test.com');

        $user->addGroup($adminGroup);
    }
}
