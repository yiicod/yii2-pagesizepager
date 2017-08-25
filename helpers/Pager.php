<?php

namespace yiicod\pagesizepager\helpers;

use Yii;
use yii\helpers\ArrayHelper;
use yiicod\base\traits\StateStorageTrait;

/**
 * Class PagerHelper
 * Pager helper to get page size
 *
 * @author Virchenko Maksim <muslim1992@gmail.com>
 *
 * @package yiicod\perpager\components
 */
class Pager
{
    use StateStorageTrait;

    /**
     * Session pager var key
     */
    const SESSION_PAGER_KEY = 'page-size-pager-session';

    /**
     * Get page size
     *
     * @param string $gridIdentifier
     * @param string $sizeVar
     * @param int $default
     *
     * @return int
     */
    public static function getPageSize(string $gridIdentifier, string $sizeVar = '', int $default = 10): int
    {
        $data = self::getStorageData();

        if (false === (Yii::$app instanceof \yii\console\Application)) {
            if ('' === $sizeVar) {
                $sizeVar = Yii::$app->session->get(self::SESSION_PAGER_KEY . $gridIdentifier);
            }

            if (null !== Yii::$app->request->getQueryParam($sizeVar, null) && (
                    false === isset($data[$gridIdentifier]) ||
                    false === isset($data[$gridIdentifier][$sizeVar]) ||
                    $data[$gridIdentifier][$sizeVar] != Yii::$app->request->getQueryParam($sizeVar)
                )
            ) {
                $data = ArrayHelper::merge($data, [
                    $gridIdentifier => [
                        $sizeVar => Yii::$app->request->getQueryParam($sizeVar),
                    ],
                ]);
                self::setStorageData($data);
            }
        }

        return (isset($data[$gridIdentifier]) && isset($data[$gridIdentifier][$sizeVar])) ?
            (int)$data[$gridIdentifier][$sizeVar] : $default;
    }

    /**
     * Method which has to be implemented by classes
     * Return path of storage folder to save data in
     *
     * @return string
     */
    protected static function getStorageKey(): string
    {
        return __CLASS__;
    }
}
