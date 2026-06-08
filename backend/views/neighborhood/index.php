<?php

use yii\helpers\Html;
use yii\grid\GridView;

/**
 * @var yii\web\View $this
 * @var backend\models\search\NeighborhoodSearch $searchModel
 * @var yii\data\ActiveDataProvider $dataProvider
 */

$this->title = 'Neighborhoods';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="neighborhood-index">
    <div class="card">
        <div class="card-header">
            <?= Html::a(Yii::t('main', 'Maxalla yaratish'), ['create'], ['class' => 'btn btn-primary btn-block btn-lg btn-block btn-outline']) ?>
        </div>

        <div class="card-body p-0">
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    
            <?php echo GridView::widget([
                'layout' => "{items}\n{pager}",
                'options' => [
                    'class' => ['gridview', 'table-responsive'],
                ],
                'tableOptions' => [
                    'class' => ['table', 'text-nowrap', 'table-striped', 'table-bordered', 'mb-0'],
                ],
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    'id',
                    'title_ru',
                    'title_uz',
                    'title_oz',
                    'district_id',
                    // 'soato_id',
                    // 'order',
                    // 'status',
                    // 'created_at',
                    // 'created_by',
                    // 'updated_at',
                    // 'updated_by',
                    // 'is_deleted:boolean',
                    // 'deleted_by',
                    // 'deleted_at',

                        ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
    
        </div>
        <div class="card-footer">
            <?php echo getDataProviderSummary($dataProvider) ?>
        </div>
    </div>

</div>
