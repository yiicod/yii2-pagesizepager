<?php

namespace yiicod\pagesizepager\widgets;

use liyunfang\pager\LinkPager;
use Yii;
use yii\base\Exception;
use yii\data\DataProviderInterface;
use yii\helpers\Html;
use yiicod\pagesizepager\helpers\Pager;
use yiicod\pagesizepager\providers\ProviderAbstract;
use yiicod\pagesizepager\providers\ProviderInterface;

/**
 * Class PageSizeLinkPager
 * Pager for grid with saving pagers in session
 *
 * @author Virchenko Maksim <muslim1992@gmail.com>
 *
 * @package yiicod\perpager\widgets
 */
class PageSizePager extends LinkPager
{
    /**
     * Page size list
     *
     * @var array
     */
    public $pageSizeList = [10, 20, 30, 50];

    /**
     * Grid id
     *
     * @var null
     */
    public $gridIdentifier = null;

    /**
     * pageSize style
     */
    public $pageSizeOptions = [
        'class' => 'form-control',
        'style' => 'display: inline-block; vertical-align: top; width: auto; margin: 20px 0;',
    ];

    /**
     * Current page size
     *
     * @var int
     */
    protected $pageSize;

    /**
     * @var ProviderInterface
     */
    protected $provider;

    public function __construct(ProviderInterface $provider, array $config = [])
    {
        $this->provider = $provider;

        parent::__construct($config);
    }

    /**
     * Run widget
     */
    public function init()
    {
        if (null === $this->gridIdentifier) {
            throw new Exception('PageSizePager "gridIdentifier" must be set.');
        }

        Yii::$app->session->set(ProviderAbstract::SESSION_PAGER_KEY . $this->gridIdentifier, $this->pagination->pageSizeParam);

        $this->pageSize = $this->provider->getPageSize($this->gridIdentifier);
    }

    /**
     * Render page size
     *
     * @return string
     */
    protected function renderPageSize()
    {
        $pageSizeList = [];

        foreach ($this->pageSizeList as $value) {
            $pageSizeList[$value] = $value;
        }

        return Html::dropDownList($this->pagination->pageSizeParam, $this->pageSize, $pageSizeList, $this->pageSizeOptions);
    }

    /**
     * Get filter selector using ActiveDataProvider
     *
     * @param DataProviderInterface $dataProvider
     *
     * @return string
     */
    public static function getFilterSelector(DataProviderInterface $dataProvider): string
    {
        return "select[name='" . $dataProvider->getPagination()->pageSizeParam . "'],input[name='" . $dataProvider->getPagination()->pageParam . "']";
    }
}
