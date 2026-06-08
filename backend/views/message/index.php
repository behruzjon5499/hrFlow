<?php

use yii\grid\GridView;
use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $searchModel common\models\MessageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('main', 'Messages');
//$this->params['breadcrumbs'][] = $this->title;
/*echo Yii::$app->language;
echo "<br>";
echo Yii::$app->getI18n()->translate('yii', 'Messages',[],Yii::$app->language);
echo "<pre>";
print_r(Yii::$app->getI18n()->getMessageSource('yii'));
print_r(Yii::$app->getI18n()->getMessageSource('yii')->translate('yii','Messages',Yii::$app->language));
echo "<pre>";
die();*/
?>

<div class="panel-simple message-index">

    <h2 class="page-header text-strong  text-center"><?= Html::encode($this->title) ?></h2>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'id' => 'kv-grid-demo',
        'dataProvider'=>$dataProvider,
        'filterModel' => $searchModel,
        'pjax'=>false,
        'toolbar'=> [
            ['content'=>
                Html::a('<i class="glyphicon glyphicon-plus"></i>', ['create'], [ 'title'=>Yii::t('main', 'Add New'), 'class'=>'btn btn-success'])
            ],
        ],

        'export'=>false,
        'bordered'=>false,
        'striped'=>false,
        'condensed'=>false,
        'responsive'=>true,
        'hover'=>true,
        'panel'=>[
            'type'=>GridView::TYPE_ACTIVE,
            'heading'=>'',
        ],
        'persistResize'=>false,
        'rowOptions'   => function ($model, $key, $index, $grid) {
            if (empty($model->translation)) {
                return ['data-id' => $model->id, 'class' => 'no-display td-pointer'];
            }else {
                return ['data-id' => $model->id, 'class' => 'td-pointer'];
            }
        },
        'columns' => [
            ['class' => 'yii\grid\SerialColumn',
                'options' => ['width' => '15px'],
                'header'=>'№'
            ],
            [
                'attribute'=>'message',
                'hAlign'=>'left',
                'vAlign'=>'middle',
                'value'=>function($model){
                    $actions = '';
                    $actions .= '<div class="hover-actions col-md-12" style="padding: 0">
                                    <a  href="'.\yii\helpers\Url::to(['/message/update','id'=>$model->id]).'">'.
                        Yii::t('main','Edit') .'
                                    </a> |
                                    <a  href="'.\yii\helpers\Url::to(['/message/view','id'=>$model->id]).'">'.
                        Yii::t('main','View') .'
                                    </a> |
                                    <a  class="text-danger" href="'.\yii\helpers\Url::to(['/message/delete','id'=>$model->id]).'"
                                         data-confirm="'.Yii::t('yii','Are you sure you want to delete this item?').'" data-method="post"
                                    >'.
                        Yii::t('main','Delete Permanently') .'
                                    </a>
                            </div>';

                    return \yii\helpers\StringHelper::truncateWords($model->message,'15') .$actions;
                },
                'format'=>"raw"
            ],
            [
                'attribute'=>'translation',
                'hAlign'=>'center',
                'vAlign'=>'middle',
                'value'=>function($model){
                    $lang = [];
                    foreach (Yii::$app->params['languages'] as $key=>$language) {
                        if($key=='en'){continue;}
                        $lang[$key]='<span class="label p-t-8 font-s-11  p-b-8 label-danger">'.$language.'</span> ';
                    }
                    foreach ($model->messages as $message) {
                        if (in_array($message->language,array_keys(Yii::$app->params['languages']))) {
                            $lang[$message->language] = '<span  data-toggle="tooltip" data-placement="top" title="" data-original-title="'.$message->translation.'" class="label p-t-8 font-s-11 p-b-8  label-success">'.Yii::$app->params['languages'][$message->language].'</span> ';
                        }
                    }
                    return implode(' ',$lang);
                },
                'format'=>"raw",
                'label'=>Yii::t('main','Translate Message'),
                'options' => ['width' => '20%'],
            ],
//            [
//                'attribute'=>'language',
//                'hAlign'=>'left',
//                'vAlign'=>'middle',
//                'label'=>Yii::t('yii','Language'),
//                'format'=>"raw",
//                'options' => ['width' => '10%'],
//                'value'=>function($model){
//                    return $model->language=='uz'?'O\'zbek':'Ўзбек';
//                },
//                'filter'=>Yii::$app->params['languages']
//            ],
        ],
    ]);

    ?>


</div>

