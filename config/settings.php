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
                        'description' => __('Determines whether you are using dev API for testing, or live API', ULTRALEET_VO_TEXTDOMAIN),
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
    ],
    'verify' => [
        'title' => __('Verification', ULTRALEET_VO_TEXTDOMAIN),
        'sections' => [
            'login' => [
                'fields' => [
                    'header' => [
                        'type' => 'section_header',
                        'title' => __('Login verification', ULTRALEET_VO_TEXTDOMAIN),
                        'text' => __('Configure VerifyOnce verification on user login.', ULTRALEET_VO_TEXTDOMAIN),
                    ],
                    'enabled' => [
                        'type' => 'checkbox',
                        'label' => __('Enabled', ULTRALEET_VO_TEXTDOMAIN),
                        'description' => __('Whether or not login verification is enabled', ULTRALEET_VO_TEXTDOMAIN),
                    ],
                    'fields' => [
                        'type' => 'checkbox_list',
                        'label' => __('Fields to check', ULTRALEET_VO_TEXTDOMAIN),
                        'options' => [
                            'email' => __('User email', ULTRALEET_VO_TEXTDOMAIN),
                        ],
                        'default' => true,
                    ],
                ],
            ],
            'custom' => [
                'fields' => [
                    'header' => [
                        'type' => 'section_header',
                        'title' => __('Custom verification', ULTRALEET_VO_TEXTDOMAIN),
                        'text' => __('Configure VerifyOnce custom verification.', ULTRALEET_VO_TEXTDOMAIN),
                    ],
                    'enabled' => [
                        'type' => 'checkbox',
                        'label' => __('Enabled', ULTRALEET_VO_TEXTDOMAIN),
                        'description' => __('Whether or not custom verification is enabled', ULTRALEET_VO_TEXTDOMAIN),
                    ],
                ],
            ],
        ],
    ],
];
