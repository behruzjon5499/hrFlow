<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/**
 * @var yii\web\View $this
 * @var common\models\Bank $model
 * @var yii\bootstrap4\ActiveForm $form
 */
?>

<div class="bank-form">
    <?php $form = ActiveForm::begin(); ?>
        <div class="card">
            <div class="card-body">
                <?php echo $form->errorSummary($model); ?>

                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <?php echo $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
                        <?php echo $form->field($model, 'mfo')->textInput(['maxlength' => true]) ?>
                        <?php echo $form->field($model, 'order')->textInput() ?>
                        <div class="card-footer">
                            <?php echo Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                        </div>
                    </div>
                    <div class="col-md-3"></div>
                </div>


            </div>

        </div>
    <?php ActiveForm::end(); ?>
</div>
