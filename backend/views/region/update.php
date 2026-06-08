<?php

/**
 * @var yii\web\View $this
 * @var common\models\Region $model
 */

$this->title = 'Update Region: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Regions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="region-update">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
