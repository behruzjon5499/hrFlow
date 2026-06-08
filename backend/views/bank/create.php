<?php

/**
 * @var yii\web\View $this
 * @var common\models\Bank $model
 */

$this->title = 'Create Bank';
$this->params['breadcrumbs'][] = ['label' => 'Banks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bank-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
