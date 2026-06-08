<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = $model->getPublicIdentity();
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">
    <div class="card">
        <div class="card-header">
            <?php  if (Yii::$app->user->can(\common\rbac\Roles::ADMINISTRATOR)){
              echo Html::a(Yii::t('main', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']);
                echo Html::a(Yii::t('main', 'Delete'), ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Yii::t('main', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                ],
            ]);} ?>

            <?php
            if (Yii::$app->user->can(\common\rbac\Roles::ADMINISTRATOR)){
                if ($model->status == \common\models\User::ACTIVE){
                    echo Html::a(Yii::t('main', 'Passive'), ['passive', 'id' => $model->id], ['class' => 'btn btn-dark']);
                }else{
                    echo Html::a(Yii::t('main', 'Active'), ['active', 'id' => $model->id], ['class' => 'btn btn-info']);
                }

            }
            ?>
        </div>
        <div class="card-body p-0">
            <?php echo DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    'username',

//                    'auth_key',
                    'email:email',
                    'statusName',
                    'created_at:datetime',
                    'updated_at:datetime',
                    'logged_at:datetime',
                ],
            ]) ?>
        </div>
    </div>
</div>
