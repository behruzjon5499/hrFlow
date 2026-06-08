<?php

/**
 * @var yii\web\View $this
 * @var common\models\District $model
 */

$this->title = 'Create District';
$this->params['breadcrumbs'][] = ['label' => 'Districts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="district-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
