<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Message */

$this->title = Yii::t('yii', 'Update') . ' : ' . \yii\helpers\StringHelper::truncateWords($model2->message,5);
$this->params['breadcrumbs'][] = ['label' => Yii::t('yii', 'Messages'), 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' =>  \yii\helpers\StringHelper::truncateWords($model[0]->translation,3), 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('yii', 'Update');
?>
<div class="message-update">

    <h2  class="page-header text-strong  text-center"><?= Html::encode($this->title) ?></h2>

    <?= $this->render('_form', [
        'model' => $model,
        'model2' => $model2,
    ]) ?>

</div>
