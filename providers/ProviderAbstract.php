<?php

namespace yiicod\pagesizepager\providers;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * Class ProviderAbstract
 *
 * @author Orlov Aleksey <aaorlov88@gmail.com>
 * @package yiicod\pagesizepager\providers
 */
abstract class ProviderAbstract implements ProviderInterface
{
    const SESSION_PAGER_KEY = 'session_pager';

    /**
     * Get page size
     *
     * @param string $gridIdentifier
     * @param string $sizeVar
     * @param int $default
     *
     * @return int
     */
    public function getPageSize(string $gridIdentifier, string $sizeVar = 'per-page', int $default = 10): int
    {
        $data = $this->getStorageState($gridIdentifier);
        if (false === (Yii::$app instanceof \yii\console\Application)) {
            if ('' === $sizeVar) {
                $sizeVar = Yii::$app->session->get(self::SESSION_PAGER_KEY . $gridIdentifier);
            }

            if (null !== Yii::$app->request->getQueryParam($sizeVar, null) && (
                    false === isset($data[$sizeVar]) ||
                    $data[$sizeVar] != Yii::$app->request->getQueryParam($sizeVar)
                )
            ) {
                $data = ArrayHelper::merge($data, [
                    $sizeVar => Yii::$app->request->getQueryParam($sizeVar),
                ]);
                $this->setStorageState($gridIdentifier, $data);
            }
        }

        return isset($data[$sizeVar]) ? (int)$data[$sizeVar] : $default;
    }
}
