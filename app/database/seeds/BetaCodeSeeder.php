<?php

class BetaCodeSeeder extends Seeder
{
    public function run()
    {
        $i=0;
        for ($i; $i<10; $i++) {
            $betaCode = new BetaCode();

            $unique_code = sha1(microtime(true).mt_rand(10000, 90000));
            $betaCode->beta_code = $unique_code;
            $betaCode->save();
        }
    }
}
