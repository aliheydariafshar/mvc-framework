<?php

return [
    'SMTP' => [
        'Host'       => 'smtp.mailtrap.io',
        'SMTPAuth'   => true,
        'Username'   => '33',
        'Password'   => '22',
        'Port'       => 587,
        'setFrom'    => [
            'mail'  =>  'support@mvc.com',
            'name'  =>  'test'
        ]
    ]
];

Config::get('mail.SMTP.setFrom.mail');