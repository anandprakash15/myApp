<?php
 require __DIR__ . '/../../common/config/container.php';
$params = array_merge(

    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log','controller'],
    'modules' => [],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'controller' => [
            'class'=>'backend\components\Controller',
        ],
        'message' => [
            'class'=>'common\components\Message',
        ],
        'myhelper' => [
            'class'=>'common\components\MyHelpers',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'bca-backend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                ['class' => 'common\components\CustomUrlRule', 'pattern' => '...', 'route' => 'site/index'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'user',  'pluralize'=>false],
            ],
        ],
        
    ],
    'params' => $params,
];
