Widget provides saving grid page size
=====================================

Provides functionality to add page size pager for any grid and save chosen value in file storage. 
This is liyunfang\yii2-widget-linkpager fork.

[![Latest Stable Version](https://poser.pugx.org/yiicod/yii2-pagesizepager/v/stable)](https://packagist.org/packages/yiicod/yii2-pagesizepager) [![Total Downloads](https://poser.pugx.org/yiicod/yii2-pagesizepager/downloads)](https://packagist.org/packages/yiicod/yii2-pagesizepager) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/yiicod/yii2-pagesizepager/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/yiicod/yii2-pagesizepager/?branch=master)[![Code Climate](https://codeclimate.com/github/yiicod/yii2-pagesizepager/badges/gpa.svg)](https://codeclimate.com/github/yiicod/yii2-pagesizepager)

Usage
-----

You can choose exists provider:
- FileProvider
- MongoProvider (You should have https://github.com/yiisoft/yii2-mongodb)
- Or you can write your self provider and configute di container

Add for any grid
----------------

```php
echo \yii\grid\GridView::widget([
    'id' => 'uniqueGridId',
    'dataProvider' => $dataProvider,
    'filterSelector' => yiicod\perpager\widgets\PageSizePager::getFilterSelector($dataProvider),
    'pager' => [
        'class' => yiicod\perpager\widgets\PageSizePager::class,
        'gridIdentifier' => 'uniqueGridId',
    ]
]);
```

Then add in data provider pagination section (for chosen grid)
--------------------------------------------------------------
```php
$dataProvider = new ActiveDataProvider([
    'query' => $query,
    'pagination' =>  [
        'pageSize' => \Yii::$container->get(\yiicod\pagesizepager\providers\ProviderInterface::class)->getPageSize('uniqueGridId'),
    ],
]);
```

Note: 'uniqueGridId' must be the same in all places to correct save grid page size