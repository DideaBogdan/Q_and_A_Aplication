<?php return array(
    'root' => array(
        'name' => '__root__',
        'pretty_version' => 'dev-main',
        'version' => 'dev-main',
        'reference' => '2ed3706e45def8ad0397da3b194b3c1663a9ee61',
        'type' => 'library',
        'install_path' => __DIR__ . '/../../',
        'aliases' => array(),
        'dev' => true,
    ),
    'versions' => array(
        '__root__' => array(
            'pretty_version' => 'dev-main',
            'version' => 'dev-main',
            'reference' => '2ed3706e45def8ad0397da3b194b3c1663a9ee61',
            'type' => 'library',
            'install_path' => __DIR__ . '/../../',
            'aliases' => array(),
            'dev_requirement' => false,
        ),
        'heroku/heroku-buildpack-php' => array(
            'pretty_version' => 'v220',
            'version' => '220.0.0.0',
            'reference' => 'af0935921c10dc7d2d2f41b06c0a66c89102d8dd',
            'type' => 'library',
            'install_path' => __DIR__ . '/../heroku/heroku-buildpack-php',
            'aliases' => array(),
            'dev_requirement' => true,
        ),
    ),
);
