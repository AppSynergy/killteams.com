<?php

return [

    'profiles' => explode(' ', 'M WS BS S T W A Ld Sv Max'),

    'suffixes' => explode('-', '"-+-+------+-'),

    'specialisms' => [
        'Leader', 'Combat', 'Comms', 'Demolitions',
        'Heavy', 'Medic', 'Scout', 'Sniper', 'Veteran', 'Zealot'
    ],

    'gear' => [
        'may' => ['TAKE', 'REPLACE'],
        'method' => ['ONEOF', 'ONEOFEACHOF', 'ALLOF'],
    ],
];
