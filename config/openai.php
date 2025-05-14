<?php

return [
    'payments' => [
        'application_fee' => '10%',
        'per'=> '1000',
        'fine_tune' => [
           'training' =>[
               'ada' => '0.0004',
               'babbage' => '0.0006',
               'curie' => '0.0030',
               'davinci' => '0.0300',
           ],
           'usage' =>[
               'ada' => '0.0016',
               'babbage' => '0.0024',
               'curie' => '0.0120',
               'davinci' => '0.1200',
           ]
        ]
    ]
];
