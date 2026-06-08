<?php

/**
 * @var yii\web\View $this
 * @var common\models\Region $model
 */

$this->title = 'Create Region';
$this->params['breadcrumbs'][] = ['label' => 'Regions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="region-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
