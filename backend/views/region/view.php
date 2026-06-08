<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * @var yii\web\View $this
 * @var common\models\Region $model
 */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Regions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="region-view">
    <div class="card">
        <div class="card-header">
            <?php echo Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?php echo Html::a('Delete', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                            'confirm' => 'Are you sure you want to delete this item?',
                            'method' => 'post',
                    ],
            ]) ?>
        </div>
        <div class="card-body">
            <?php echo DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                            'id',
                            'parent_id',
                            'title_ru',
                            'title_uz',
                            'title_oz',
                            'type',
                            'order',
                            'status',
                            'created_at',
                            'created_by',
                            'updated_at',
                            'updated_by',
                            'is_deleted:boolean',
                            'deleted_by',
                            'deleted_at',
                            'soato_id',
                            [
                                    'attribute' => 'extra_ids',
                                    'value' => function ($model) {
                                        return is_array($model->extra_ids)
                                                ? implode(', ', $model->extra_ids)
                                                : $model->extra_ids;
                                    }
                            ],
                            [
                                    'attribute' => 'extra_auto_region_ids',
                                    'value' => function ($model) {
                                        return is_array($model->extra_auto_region_ids)
                                                ? implode(', ', $model->extra_auto_region_ids)
                                                : $model->extra_auto_region_ids;
                                    }
                            ],
                    ],
            ]) ?>
        </div>
    </div>
</div>
