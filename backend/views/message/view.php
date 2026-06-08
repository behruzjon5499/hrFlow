<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Message */

$this->title = $model->message;
$this->params['breadcrumbs'][] = ['label' => Yii::t('main', 'Messages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="message-view">

    <p>
        <?= Html::a(Yii::t('yii', 'Add New'), ['create'], ['class' => 'btn btn-w-m btn-success']) ?>
        <?= Html::a(Yii::t('yii', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-w-m btn-primary']) ?>
        <?= Html::a(Yii::t('yii', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-w-m btn-danger',
            'data' => [
                'confirm' => Yii::t('main', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <table class="table table-stripped table-bordered ibox-content">
        <tr>
            <td style="width: 20%"><?= Yii::t('main', 'Message')?>(English)</td>
            <td><?= $this->title?></td>
        </tr>
        <?php
        foreach ($model2 as $item) { ?>
            <tr>
                <td><?= Yii::$app->params['languages'][$item['language']] ?></td>
                <td><?= $item['translation'] ?></td>
            </tr>
        <?php }  ?>
    </table>


</div>
<?php

$this->registerJsFile(Yii::$app->homeUrl."backend/vendors/jquery/dist/jquery.min.js");
$this->registerJsFile(Yii::$app->homeUrl."backend/vendors/bootstrap/dist/js/bootstrap.min.js");

?>
