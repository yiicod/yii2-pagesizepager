<?php

namespace yiicod\pagesizepager\providers;

use Yii;
use yii\mongodb\Query;

class MongoProvider extends ProviderAbstract
{
    /**
     * Get storage state value
     *
     * @param string $key
     * @param $default
     *
     * @return mixed
     */
    public function getStorageState(string $key, $default = null): array
    {
        $query = new Query();
        $row = $query
            ->from('yii_page_size')
            ->where(['name' => $key])
            ->one();

        return $row['value'] ?? [];
    }

    /**
     * Set storage state value
     *
     * @param string $key
     * @param $value
     */
    public function setStorageState(string $key, array $value)
    {
        $collection = Yii::$app->mongodb->getCollection('yii_page_size');
        $collection->update(['name' => $key], ['value' => $value], [
            'upsert' => true,
        ]);
    }
}
