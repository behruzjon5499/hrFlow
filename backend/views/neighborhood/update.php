<?php

/**
 * @var yii\web\View $this
 * @var common\models\Neighborhood $model
 */

$this->title = 'Update Neighborhood: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Neighborhoods', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="neighborhood-update">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
