<?php

use common\grid\EnumColumn;
use common\models\User;
use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\grid\GridView;
use rmrevin\yii\fontawesome\FAS;
use yii\helpers\Url;

/**
 * @var yii\web\View $this
 * @var backend\models\search\UserSearch $searchModel
 * @var yii\data\ActiveDataProvider $dataProvider
 */
$this->title = Yii::t('main', 'Users');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="card">
    <div class="card-header">
        <?= Html::a(Yii::t('main', 'Create new User'), ['create'], ['class' => 'btn btn-primary btn-block btn-lg btn-block btn-outline']) ?>
    </div>

    <div class="card-body p-0">
        <?php echo GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'rowOptions' => function (
                $model,
                $key,
                $index,
                $grid
            ) {
                return [
                    'id' => $key,
                    'ondblclick' => 'location.href="'
                        . Url::to(['view'])
                        . '?id="+(this.id);',
                ];
            },
            'layout' => "{items}\n{pager}",
            'options' => [
                'class' => ['gridview', 'table-responsive'],
            ],
            'tableOptions' => [
                'class' => ['table', 'text-nowrap', 'table-striped', 'table-bordered', 'mb-0'],
            ],
            'columns' => [
                [
                    'label'=>t("ID"),
                    'format' => 'raw',
                    'value'=>function ($data) {
                        return Html::a($data->id,['user/view','id'=>$data->id]);
                    },
                ],

                [
                    'label'=>t("Username"),
                    'format' => 'raw',
                    'value'=>function ($data) {
                        return Html::a($data->username,['user/view','id'=>$data->id]);
                    },
                ],
                'email:email',
                [
                    'class' => EnumColumn::class,
                    'attribute' => 'status',
                    'label' => t("Status"),
//                    'enum' => User::statuses(),
//                    'filter' => User::statuses()
                ],
                [
                    'attribute' => t("created_at"),
                    'value' => 'created_at',
                    'format' => 'datetime',
                    'label'=>t('created_at'),
                    'filter' => \dosamigos\datepicker\DatePicker::widget(
                        [
                            'model' => $searchModel,
                            'attribute' => 'created_at',
                            'template' => '{addon}{input}',
                            'clientOptions' => [
                                'autoclose' => true,
                                'format' => 'yyyy-mm-dd',
                                'viewMode' => 'day',
                                'minViewMode' => 'day',
                            ]
                        ]
                    )
                ],
                [
                    'attribute' => t("logged_at"),
                    'value' => 'logged_at',
                    'format' => 'datetime',
                    'label'=>t("logged_at"),
                    'filter' => \dosamigos\datepicker\DatePicker::widget(
                        [
                            'model' => $searchModel,
                            'attribute' => 'logged_at',
                            'template' => '{addon}{input}',
                            'clientOptions' => [
                                'autoclose' => true,
                                'format' => 'yyyy-mm-dd',
                                'viewMode' => 'day',
                                'minViewMode' => 'day',
                            ]
                        ]
                    )
                ],

                // 'updated_at',

//                [
//                    'class' => \common\widgets\ActionColumn::class,
//                    'template' => '{login} {view} {update} {delete}',
//                    'options' => ['style' => 'width: 140px'],
//                    'buttons' => [
//                        'login' => function ($url) {
//                            return Html::a(
//                                FAS::icon('sign-in-alt', ['aria' => ['hidden' => true], 'class' => ['fa-fw']]),
//                                $url,
//                                [
//                                    'title' => Yii::t('backend', 'Login'),
//                                    'class' => ['btn', 'btn-xs', 'btn-secondary']
//                                ]
//                            );
//                        },
//                    ],
//                    'visibleButtons' => [
//                        'login' => Yii::$app->user->can('administrator')
//                    ]
//
//                ],
            ],
        ]); ?>
    </div>

    <div class="card-footer">
        <?php echo getDataProviderSummary($dataProvider) ?>
    </div>
</div>
