<?php

class SentryDevSeeder extends Seeder
{
    public function run(){
        Sentry::createGroup(array(
            'name'        => 'superuser',
            'permissions' => array(
                'superuser' => 1,
            ),
        ));

        $adminGroup = Sentry::findGroupById(1);

        $user = Sentry::findUserById(1);
        $user->addGroup($adminGroup);
    }
}