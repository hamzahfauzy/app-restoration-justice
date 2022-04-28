<?php

return [
    'tblname'    => [
        'field1','field2'
    ],

    'offices' => [
        'name'
    ],

    'cases' => [
        'office_id' => [
            'label' => 'Kantor',
            'type' => 'options-obj:offices,id,name',
        ],
        'title' => [
            'label' => 'Judul Perkara',
            'type'  => 'text'
        ],
        'date' => [
            'label' => 'Waktu Perkara',
            'type'  => 'datetime-local'
        ],
        'location' => [
            'label' => 'Lokasi Perkara',
            'type'  => 'text'
        ],
        'reporter' => [
            'label' => 'Pelapor',
            'type'  => 'text'
        ],
        'reported' => [
            'label' => 'Terlapor',
            'type'  => 'text'
        ],
        'description' => [
            'label' => 'Kronologi',
            'type'  => 'textarea'
        ],
        'loss' => [
            'label' => 'Kerugian',
            'type'  => 'number'
        ]
    ],
    'case_schedules' => [
        'date' => [
            'label' => 'Tanggal',
            'type'  => 'datetime-local'
        ],
        'place' => [
            'label' => 'Tempat',
            'type'  => 'text'
        ],
        'meeting_url' => [
            'label' => 'Link',
            'type'  => 'url'
        ]
    ],
    'case_agreements' => [
        'name' => [
            'label' => 'Nama',
            'type'  => 'text'
        ],
        'phone' => [
            'label' => 'No. WA',
            'type'  => 'number'
        ],
        'agreement_as' => [
            'label' => 'Sebagai',
            'type'  => 'options:Tokoh Agama|Pejabat RT/RW/Lurah|Akademisi'
        ],
    ]
];