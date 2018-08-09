<?php

return [

    'factions' => [
        'Adeptus Astartes', 'Grey Knights', 'Deathwatch', 'Astra Militarum',
        'Adeptus Mechanicus', 'Heretic Astartes', 'Death Guard', 'Thousand Sons',
        'Asuryani', 'Drukhari', 'Harlequins', 'Necrons', 'Orks', 'T\'au Empire',
        'Tyranids', 'Genestealer Cults',
    ],

    'profiles' => explode(' ', 'M WS BS S T W A Ld Sv Max'),

    'suffixes' => explode('-', '"-+-+------+-'),

    'specialisms' => [
        'Leader', 'Combat', 'Comms', 'Demolitions',
        'Heavy', 'Medic', 'Scout', 'Sniper', 'Veteran', 'Zealot'
    ],

    'specialism_abilities' => [
        // ['Name', level, parent_id, specialism_id]
        // Leader
        ['Resourceful', 1, null, 1],
        ['Bold', 2, 1, 1],
        ['Inspiring', 2, 1, 1],
        ['Paragon', 3, 2, 1],
        ['Tyrant', 3, 2, 1],
        ['Tactician', 3, 3, 1],
        ['Mentor', 3, 3, 1],
        // Combat
        ['Expert Fighter', 1, null, 2],
        ['Warrior Adept', 2, 8, 2],
        ['Deadly Counter', 2, 8, 2],
        ['Deathblow', 3, 9, 2],
        ['Combat Master', 3, 9, 2],
        ['Killer Instinct', 3, 10, 2],
        ['Bloodlust', 3, 10, 2],
    ],

    'gear' => [
        'may' => ['TAKE', 'REPLACE'],
        'method' => ['ONEOF', 'ONEOFEACHOF', 'ALLOF'],
    ],
];
