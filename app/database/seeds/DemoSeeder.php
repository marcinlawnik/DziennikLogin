<?php

class DemoSeeder extends Seeder {

    /**
     * Run the DEMO database seeds.
     *
     * @return void
     */
    public function run()
    {
        Eloquent::unguard();

        $this->call('UsersDemoSeeder');
        $this->call('GroupsDemoSeeder');
        $this->call('SubjectsDemoSeeder');
        $this->call('OAuthDemoSeeder');
        $this->call('GradesDemoSeeder');

    }
}