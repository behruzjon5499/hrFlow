<?php

/**
 * Yii2 Shortcuts
 * @author Eugene Terentev <eugene@terentev.net>
 * @author Victor Gonzalez <victor@vgr.cl>
 * -----
 * This file is just an example and a place where you can add your own shortcuts,
 * it doesn't pretend to be a full list of available possibilities
 * -----
 */

use yii\data\ArrayDataProvider;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * @return int|string
 */
function getMyId()
{
  return Yii::$app->user->getId();
}

/**
 * @param string $view
 * @param array $params
 * @return string
 */
function render($view, $params = [])
{
  return Yii::$app->controller->render($view, $params);
}

/**
 * @param $url
 * @param int $statusCode
 * @return \yii\web\Response
 */
function redirect($url, $statusCode = 302)
{
  return Yii::$app->controller->redirect($url, $statusCode);
}

/**
 * @param string $key
 * @param mixed $default
 * @return mixed
 */
function env($key, $default = null)
{
  // getenv is disabled when using createImmutable with Dotenv class
  if (isset($_ENV[$key])) {
    return $_ENV[$key];
  } elseif (isset($_SERVER[$key])) {
    return $_SERVER[$key];
  }

  return $default;
}

/**
 * Renders any data provider summary text.
 *
 * @param \yii\data\DataProviderInterface $dataProvider
 * @param array $options the HTML attributes for the container tag of the summary text
 * @return string the HTML summary text
 */
function getDataProviderSummary($dataProvider, $options = [])
{
  $count = $dataProvider->getCount();
  if ($count <= 0) {
    return '';
  }
  $tag = ArrayHelper::remove($options, 'tag', 'div');
  if (($pagination = $dataProvider->getPagination()) !== false) {
    $totalCount = $dataProvider->getTotalCount();
    $begin = $pagination->getPage() * $pagination->pageSize + 1;
    $end = $begin + $count - 1;
    if ($begin > $end) {
      $begin = $end;
    }
    $page = $pagination->getPage() + 1;
    $pageCount = $pagination->pageCount;
    return Html::tag($tag, Yii::t('main', 'Showing <b>{begin, number}-{end, number}</b> of <b>{totalCount, number}</b> {totalCount, plural, one{item} other{items}}.', [
      'begin' => $begin,
      'end' => $end,
      'count' => $count,
      'totalCount' => $totalCount,
      'page' => $page,
      'pageCount' => $pageCount,
    ]), $options);
  } else {
    $begin = $page = $pageCount = 1;
    $end = $totalCount = $count;
    return Html::tag($tag, Yii::t('main', 'Total <b>{count, number}</b> {count, plural, one{item} other{items}}.', [
      'begin' => $begin,
      'end' => $end,
      'count' => $count,
      'totalCount' => $totalCount,
      'page' => $page,
      'pageCount' => $pageCount,
    ]), $options);
  }
}

/**
 * @param $query
 * @param array $params
 * @return array
 */
function paginate($query,$perPage=null)
{
  $pageSize =$perPage?? Yii::$app->request->get('perPage', 10);
  $currentPage = Yii::$app->request->get('currentPage', 0);
  $countQuery = clone $query;
  $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => $pageSize, 'page' => $currentPage]);
  $models = $query->offset($pages->offset)
    ->limit($pages->limit)
    ->all();

  return [
    'data' => $models,
    'meta' => [
      'totalCount' => (int) $pages->totalCount,
      'pageCount' => $pages->getPageCount(),
      'currentPage' => $pages->getPage(),
      'perPage' => $pages->getPageSize(),
    ],
  ];
}

function showPrice($price)
{
  return number_format($price, 2, '.', ' ');
}
function arrayPagination($array)
{
    $perPage = Yii::$app->request->get('perPage', 20);
    $page = Yii::$app->request->get('currentPage', 0);
    $dataProvider= new ArrayDataProvider([
        'allModels' => $array,
        'pagination' => [
            'pageSize' => $perPage,
            'page' => $page - 1, // Yii page index 0 dan boshlanadi
        ],
    ]);
    $metaData = [
        'totalCount' => $dataProvider->getTotalCount(),
        'pageCount' => $dataProvider->pagination->getPageCount(),
        'currentPage' => $dataProvider->pagination->getPage() + 1, // 0 index hisoblanadi
        'perPage' => $dataProvider->pagination->getPageSize(),
    ];
    return [
        'data' => $dataProvider->getModels(),
        'meta' => $metaData,
    ];
}
function  getRequestParams()
{
    $requestParams = Yii::$app->getRequest()->getBodyParams();
    if (empty($requestParams)) {
        $requestParams = Yii::$app->getRequest()->getQueryParams();
    }
    return $requestParams;
}