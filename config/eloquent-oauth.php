<?php

use App\User;

return [
    'model' => User::class,
    'table' => 'oauth_identities',
    'providers' => [
        'facebook' => [
            'client_id' => '245392435841292',
            'client_secret' => 'f8399c29b24013991204ae729ce7d7f0',
            'redirect_uri' => 'http://localhost:8000/facebook/redirect',
            'scope' => [],
        ],
        'google' => [
            'client_id' => '657940062137-oko6q97g7m7tc6pj4nmtqmof36m6ttrs.apps.googleusercontent.com',
            'client_secret' => 'tNd31A_YOlY0nRGmPR24eJO3',
            'redirect_uri' => 'http://localhost:8000/google/redirect',
            'scope' => ['email','profile','https://www.googleapis.com/auth/drive'],
        ],
        'github' => [
            'client_id' => '12345678',
            'client_secret' => 'y0ur53cr374ppk3y',
            'redirect_uri' => 'https://example.com/your/github/redirect',
            'scope' => [],
        ],
        'linkedin' => [
            'client_id' => '12345678',
            'client_secret' => 'y0ur53cr374ppk3y',
            'redirect_uri' => 'https://example.com/your/linkedin/redirect',
            'scope' => [],
        ],
        'instagram' => [
            'client_id' => '12345678',
            'client_secret' => 'y0ur53cr374ppk3y',
            'redirect_uri' => 'https://example.com/your/instagram/redirect',
            'scope' => [],
        ],
        'soundcloud' => [
            'client_id' => '12345678',
            'client_secret' => 'y0ur53cr374ppk3y',
            'redirect_uri' => 'https://example.com/your/soundcloud/redirect',
            'scope' => [],
        ],
    ],
];
