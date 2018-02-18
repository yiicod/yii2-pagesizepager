<?php

namespace yiicod\pagesizepager\providers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;
use yii\helpers\Json;

/**
 * Class FileProvider
 *
 * @author Orlov Aleksey <aaorlov88@gmail.com>
 * @package yiicod\base\traits
 */
class FileProvider extends ProviderAbstract
{
    public $dir = '@runtime';

    /**
     * Get storage state value
     *
     * @param string $key
     * @param $default
     *
     * @return mixed
     */
    public function getStorageState(string $key, $default = null)
    {
        $data = $this->getStorageData();

        return isset($data[$key]) ? $data[$key] : $default;
    }

    /**
     * Set storage state value
     *
     * @param string $key
     * @param $value
     */
    public function setStorageState(string $key, array $value)
    {
        $this->setStorageData([$key => $value]);
    }

    /**
     * Get storage data
     *
     * @param bool $decode
     *
     * @return array|string
     */
    protected function getStorageData(bool $decode = true)
    {
        $data = Json::encode([]);

        $storageFilePath = $this->getStorageFilePath();
        if (file_exists($storageFilePath)) {
            $data = file_get_contents($storageFilePath);
        }

        return ($decode) ? Json::decode($data) : $data;
    }

    /**
     * Add data to storage
     *
     * @param array $newData
     */
    protected function setStorageData(array $newData)
    {
        $data = ArrayHelper::merge($this->getStorageData(), $newData);

        file_put_contents($this->getStorageFilePath(), Json::encode($data));
    }

    /**
     * Get path to storage file.
     *
     * @return string
     */
    protected function getStorageFilePath(): string
    {
        if (false === is_dir(Yii::getAlias($this->dir))) {
            FileHelper::createDirectory(Yii::getAlias($this->dir), 0755, true);
        }

        return Yii::getAlias($this->dir) . DIRECTORY_SEPARATOR . 'yii_page_size.bin';
    }
}
