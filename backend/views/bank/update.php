<?php

/**
 * @var yii\web\View $this
 * @var common\models\Bank $model
 */

$this->title = 'Update Bank: ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Banks', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="bank-update">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
