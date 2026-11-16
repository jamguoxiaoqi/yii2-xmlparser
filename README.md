<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/993323" height="100px">
    </a>
    <h1 align="center">Yii2 XML Parser</h1>
    <br>
</p>

An XML request parser just like built-in [yii\web\JsonParser](https://www.yiiframework.com/doc/api/2.0/yii-web-jsonparser).

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/):

```
composer require --prefer-dist jamguoxiaoqi/yii2-xmlparser
```

or

```
php composer.phar require --prefer-dist jamguoxiaoqi/yii2-xmlparser
```

Usage
-----

```php
# app/config/main.php (your configuration file)

<?php

return [
    'components' => [
        'request' => [
            'parsers' => [
                'application/xml' => 'jamguoxiaoqi\yii\web\XmlParser',
                'text/xml' => 'jamguoxiaoqi\yii\web\XmlParser',
            ]
        ],
    ],
];
```

and then:

```php
$posts = Yii::$app->request->post();
$post_foo = Yii::$app->request->post('foo');
```


License
-------

![License](https://img.shields.io/github/license/jamguoxiaoqi/yii2-xmlparser)
