<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SourceMessageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('yii', 'Messages');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-lg-12">
        <div class="tabs-container">
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#tab-1" aria-expanded="true"> Список сообщений</a></li>
            </ul>
            <div class="tab-content">
                <div id="tab-1" class="tab-pane active">
                    <div class="panel-body">
                        <?= Html::a(Yii::t('yii', 'Create new message'), ['create'], ['class' => 'btn btn-primary btn-block btn-lg btn-block btn-outline']) ?>

                        <?= GridView::widget([
                            'dataProvider' => $dataProvider,
                            'layout' => "{items}\n{pager}",
                            'pager' => [
                                'options' => ['class' => 'pagination'],
                                'prevPageLabel' => '<',
                                'nextPageLabel' => '>',
                                'firstPageLabel' => '<<',
                                'lastPageLabel' => '>>',
                                'maxButtonCount' => 10,
                            ],
                            'filterModel' => $searchModel,
                            //'showHeader' => false,
                            'tableOptions' => [
                                'class' => 'footable table table-striped table-hover', // можно задать свой, тут 100% ширина блока
                            ],
                            'rowOptions' => function ($model, $key, $index, $grid) {
                                return [
                                    'id' => $key,
                                    'ondblclick' => 'location.href="'
                                        . Yii::$app->urlManager->createUrl('message/view')
                                        . '?id="+(this.id);',
                                    'onclick' => '
                                                    $("table tr").removeClass("selected");
                                                    $(this).addClass("selected");
                                                // $("#modal").modal("show").find(".modal-body").load("' . Yii::$app->urlManager->createUrl('department/view') . '?id="+this.id);',
                                ];
                            },

                            // 'summary' => '<br/><p class="text-center text-muted">Всего найдено </p>',


                            'columns' => [
                                [
                                    'class' => 'yii\grid\SerialColumn',
                                    'headerOptions' => ['width' => '40'],
                                ],
                                //'id',
                                //'category',

                                [
                                    'attribute' => 'message',
                                    'format' => 'raw',
                                    'label' => Yii::t('yii', 'Message'),

                                    'value' => function ($model) use ($searchModel) {

                                        $lang = $searchModel->language ? $searchModel->language : 'en';
                                        foreach ($model->messages as $message) {
                                            if (in_array($message->language, array_keys(Yii::$app->params['languages']))) {
                                                if ($message->language == $lang) {
                                                    return $message->translation;
                                                }
                                            }
                                        }
                                        return $model->message;
                                    },
                                    'contentOptions' => ['width' => '210']
                                ],

                                [
                                    //            'attribute' => 'address',
                                    'format' => 'html',
                                    'label' => Yii::t('yii', 'Languages'),
                                    'filter' => Html::activeDropDownList($searchModel, 'language', ['uz' => 'uz', 'uzc' => 'uzc', 'ru' => 'Рус'], ['class' => 'form-control', 'prompt' => 'Select Category']),

//                                    'filter' => [0 => 'Uz',1 => 'Уз',2 => 'Рус'],
                                    'value' => function ($model) {
                                        $lang = [];
                                        foreach (Yii::$app->params['languages'] as $key => $language) {
                                            if ($key == 'en') {
                                                continue;
                                            }
                                            $lang[$key] = '<span class="label p-t-8 font-s-11  p-b-8 label-danger">' . $language . '</span> ';
                                        }
                                        foreach ($model->messages as $message) {
                                            if (in_array($message->language, array_keys(Yii::$app->params['languages']))) {
                                                $lang[$message->language] = '<span  data-toggle="tooltip" data-placement="top" title="" data-original-title="' . $message->translation . '" class="label p-t-8 font-s-11 p-b-8  label-success">' . Yii::$app->params['languages'][$message->language] . '</span> ';
                                            }
                                        }
                                        return implode(' ', $lang);
                                    },
                                    'contentOptions' => ['width' => '210']
                                ],
                                [
                                    'attribute' => 'category',
                                    'label' => '#',
                                    'filter' => false,
                                    'format' => 'raw',
                                    'headerOptions' => ['width' => '40'],
                                ],


                                //['class' => 'yii\grid\ActionColumn'],


                            ],
                            'options' => ['class' => 'table table-striped table-bordered ibox-content'],
                            //'options' => ['tag' => 'div', 'class' => 'col-lg-12'],
                        ]); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>