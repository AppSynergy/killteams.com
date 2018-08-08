<?php

return [

    'profiles' => explode(' ', 'M WS BS S T W A Ld Sv Max'),

    'suffixes' => explode('-', '"-+-+------+-'),

    'gear' => [
        'may' => ['TAKE', 'REPLACE'],
        'method' => ['ONEOF', 'ONEOFEACHOF', 'ALLOF'],
    ],
];
