PageSizePager widget extends liyunfang\yii2-widget-linkpager and provides saving grid page size
===============================================================================================

Provides functionality to add page size pager for any grid and save chosen value in file storage.

Usage
-----

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
        'pageSize' => PagerHelper::getPageSize('uniqueGridId'),
    ],
]);
```

Note: 'uniqueGridId' must be the same in all places to correct save grid page size