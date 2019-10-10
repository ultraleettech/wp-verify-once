<?php

return [
    'api' => [
        'title' => __('API', ULTRALEET_VO_TEXTDOMAIN),
        'sections' => [
            'mode' => [
                'fields' => [
                    'header' => [
                        'type' => 'section_header',
                        'text' => __('Configure your integrator API mode and credentials.', ULTRALEET_VO_TEXTDOMAIN),
                    ],
                    'dev' => [
                        'type' => 'checkbox',
                        'label' => __('Development mode', ULTRALEET_VO_TEXTDOMAIN),
                        'description' => __('Determines whether you are using dev API for testing, or live API'),
                    ],
                ],
            ],
            'live' => [
                'fields' => [
                    'header' => [
                        'type' => 'section_header',
                        'title' => __('Live credentials', ULTRALEET_VO_TEXTDOMAIN),
                    ],
                    'username' => [
                        'label' => __('Username', ULTRALEET_VO_TEXTDOMAIN),
                    ],
                    'password' => [
                        'label' => __('Password', ULTRALEET_VO_TEXTDOMAIN),
                    ],
                ],
            ],
            'dev' => [
                'fields' => [
                    'header' => [
                        'type' => 'section_header',
                        'title' => __('Dev credentials', ULTRALEET_VO_TEXTDOMAIN),
                        'description' => __('Configure your integrator API mode and credentials.', ULTRALEET_VO_TEXTDOMAIN),
                    ],
                    'username' => [
                        'label' => __('Username', ULTRALEET_VO_TEXTDOMAIN),
                    ],
                    'password' => [
                        'label' => __('Password', ULTRALEET_VO_TEXTDOMAIN),
                    ],
                ],
            ],
        ],
    ]
];
