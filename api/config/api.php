<?php
 
$db     = require(__DIR__ . '/../../config/db.php');
$params = require(__DIR__ . '/params.php');
 
$config = [
    'id' => 'api',
    // Need to get one level up:
    'basePath' => dirname(__DIR__).'/..',
    'bootstrap' => ['log'],
    'components' => [
        'response' => [
            'class' => 'yii\web\Response',
            'on beforeSend' => function ($event) {
                $response = $event->sender;
                if ($response->data !== null) {
                    $response->data = [
                        'success' => $response->isSuccessful,
                        ($response->isSuccessful ? 'data' : 'error') => $response->data,
                    ];
                }
            },
        ],
        'request' => [
            // Enable JSON Input:
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        // Set this enable authentication in our API
        'user' => [
            'identityClass'  => 'app\models\User',
            'enableAutoLogin'  => false, // Don't forget to set Auto login to false
            'enableSession' => false,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning', 'trace'],
                     // Create API log in the standard log dir
                     // But in file 'api.log':
                    'logFile' => '@app/runtime/logs/api.log',
                ],
            ],
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
                ['class' => 'yii\rest\UrlRule', 'controller' => ['v1/user'],'extraPatterns' => [
                    'POST login' => 'login',
                    'POST logout' => 'logout',
                    'POST username' => 'username',
                    'GET search' => 'search',
                    ],
                ],
                ['class' => 'yii\rest\UrlRule', 'controller' => ['v1/thread'], 'extraPatterns' => [
                    'GET <id:\d+>/posts' => 'posts',
                    'POST <id:\d+>/addview' => 'addview',
                ],
                ],
                ['class' => 'yii\rest\UrlRule', 'controller' => ['v1/post'],
                ],
                ['class' => 'yii\rest\UrlRule', 'controller' => ['v1/me'], 'pluralize' => false,
                    'extraPatterns' => [
                        'POST' => 'update',
                        'GET posts' => 'posts',
                        'GET threads' => 'threads',
                        'POST post' => 'post',
                        'POST thread' => 'thread',
                        'POST avatar' => 'avatar',
                        'DELETE avatar' => 'avatar',
                        'POST boards' => 'createBoard',
                        'DELETE boards/<id:\d+>' => 'deleteBoard',
                        'PUT boards/<id:\d+>' => 'updateBoard',
                        'DELETE boards/<id:\d+>/image' => 'boardImage',
                        'POST boards/<id:\d+>/image' => 'boardImage',
                        'GET boards' => 'boards',
                        'GET boards/<id:\d+>' => 'viewBoards',
                        'POST boards/<id:\d+>/content' => 'boardContent',
                        'DELETE boards/<id:\d+>/content' => 'boardContent',
                        'GET boards/<id:\d+>/content' => 'boardContent'
                    ],
                ],
                ['class' => 'yii\rest\UrlRule', 'controller' => ['v1/category'], 'pluralize' => false,
                    'extraPatterns' => [
                        'GET <id:\d+>/pages' => 'pages',
                        'POST <id:\d+>/image' => 'image',
                        'DELETE <id:\d+>/image' => 'image',
                    ],
                ],
                ['class' => 'yii\rest\UrlRule', 'controller' => ['v1/page'], 'pluralize' => false,
                    'extraPatterns' => [
                        'GET <id:\d+>/articles' => 'articles',
                        'POST <id:\d+>/image' => 'image',
                        'DELETE <id:\d+>/image' => 'image',
                    ],
                ],
                ['class' => 'yii\rest\UrlRule', 'controller' => ['v1/article'], 'pluralize' => false,
                    'extraPatterns' => [
                        'GET <id:\d+>/comments' => 'comments',
                    ],
                ],
                ['class' => 'yii\rest\UrlRule', 'controller' => ['v1/comment'], 'pluralize' => false,
                ],
                ['class' => 'yii\rest\UrlRule', 'controller' => ['v1/pagecategory'], 'pluralize' => false,
                ],
                ['class' => 'yii\rest\UrlRule', 'controller' => ['v1/board'], 'pluralize' => false,
                    'extraPatterns' => [
                        'POST <id:\d+>/content' => 'addContent',
                        'DELETE <id:\d+>/content' => 'deleteContent',
                    ],
                ],
            ],
        ],
        'db' => $db,
    ],
    'modules' => [
        'v1' => [
            'basePath' => '@app/api/modules/v1', // base path for our module class
            'class' => 'app\api\modules\v1\Api', // Path to module class
        ]
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        'allowedIPs' => ['127.0.0.1', '::1', '46.71.208.183']
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'allowedIPs' => ['127.0.0.1', '::1', '46.71.92.21']
    ];
}

return $config;
