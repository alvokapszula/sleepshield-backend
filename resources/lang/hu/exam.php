<?php

return [

    'time' => 'Vizsgálat ideje',
    'user' => 'Orvos',
    'comments' => 'Megjegyzések',
    'patient' => 'Páciens',

    'messages' => [
        'already-started' => 'A vizsgálat már fut.',
        'havent-started' => 'A vizsgálat még nem fut.',
        'already-ended' => 'A vizsgálat már lezárult.',
        'patient-has-exam-running' => 'A páciensnek már van <a href="/exams/:exam">futó vizsgálata</a>.',
        'shield-has-exam-running' => 'A kapszulában már <a href="/exams/:exam">fut vizsgálat</a>.',
    ],

    'delete' => [
        'title' => 'Vizsgálat törlése',
        'message' => 'Biztosan törli a vizsgálatot?',
    ],

    'alarms' => [
        'type' => 'Típus',
        'sensor' => 'Szenzor',
        'value' => 'Érték',
        'time' => 'Időpont',
        'high' => 'Magas érték',
        'norm' => 'Normál érték',
        'low' => 'Alacsony érték',
    ],

];
