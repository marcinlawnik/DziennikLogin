<?php

return array(

    // Database configuration - app/config/database.php
    'mysql_database' => 'DziennikLogin',
    'mysql_username' => 'root',
    'mysql_password' => 'lolpass',
    //Mail configuration - app/config/mail.php
    'mail_driver' => 'smtp',
    'smtp_host' => '',
    'smtp_port' => '',
    'mail_from' => "array('address' => null, 'name' => null)",
    'mail_encryption' => 'tls',
    'mail_username' => '',
    'mail_password' => '',
    'sendmail_path' => '/usr/sbin/sendmail -bs',
    'mail_pretend' => true,

);
