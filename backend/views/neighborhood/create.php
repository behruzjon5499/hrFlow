<?php

/**
 * @var yii\web\View $this
 * @var common\models\Neighborhood $model
 */

$this->title = 'Create Neighborhood';
$this->params['breadcrumbs'][] = ['label' => 'Neighborhoods', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="neighborhood-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
