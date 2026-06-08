<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/**
 * @var yii\web\View $this
 * @var common\models\Neighborhood $model
 * @var yii\bootstrap4\ActiveForm $form
 */
?>

<div class="neighborhood-form">
    <?php $form = ActiveForm::begin(); ?>
        <div class="card">
            <div class="card-body">
                <?php echo $form->errorSummary($model); ?>

                <div class="row">
                    <div class="col-md-8">
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#ru" aria-controls="ru" role="tab" data-toggle="tab">Русский</a>
                            </li>
                            <li role="presentation" class=""><a href="#uz" aria-controls="uz" role="tab" data-toggle="tab">Узбекский</a>
                            </li>
                            <li role="presentation" class=""><a href="#oz" aria-controls="oz" role="tab" data-toggle="tab">Крилл</a>
                            </li>
                        </ul>

                        <div class="tab-content">
                            <br>
                            <div role="tabpanel" class="tab-pane active" id="ru">
                                <?= $form->field($model, 'title_ru')->textInput(['maxlength' => true])->label(t('Nomi ru')) ?>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="uz">
                                <?= $form->field($model, 'title_uz')->textInput(['maxlength' => true])->label(t('Nomi uz')) ?>
                            </div>

                            <div role="tabpanel" class="tab-pane" id="oz">
                                <?= $form->field($model, 'title_oz')->textInput(['maxlength' => true])->label(t('Nomi oz')) ?>

                            </div>
                        </div>

                    </div>
                    <div class="col-md-4">

                        <?php echo $form->field($model, 'district_id')->dropDownList(ArrayHelper::map(\common\models\District::find()->all(), 'id', 'title_uz'), ['prompt' => Yii::t('backend', 'Please select an item...')]) ?>

                        <?php echo $form->field($model, 'status')->textInput()?>

                        <?php echo $form->field($model, 'order')->textInput() ?>

                    </div>
                </div>

            </div>
            <div class="card-footer">
                <?php echo Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>
        </div>
    <?php ActiveForm::end(); ?>
</div>
