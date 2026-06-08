<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Message */
/* @var $form yii\widgets\ActiveForm */
//Yii::$app->session->setFlash("", "awdawdawd");
?>
<div class="message-form ">

    <?php $form = ActiveForm::begin(); ?>
    <?php $form->errorSummary($model2); ?>
    <?php $form->errorSummary($model); ?>

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-sm-12 b-r">
                            <div class="form-group">
                                <?= $form->field($model2, 'message')
                                    ->textarea(['class'=>'form-control border-left-color','rows' => 5])
                                    ->hint(Yii::t('yii','Message must be In English Language!!!')) ?>
                            </div>
                            <div class="form-group">
                                <?php
                                $i=0;
                                foreach (Yii::$app->params['languages'] as $url => $lang): ?>

                                    <?php
                                    $class = '';
                                    $button = '';
                                    if($url=='uz'){
                                        $class='latin-text';

                                    } ?>
                                    <?= $form->field($model, 'trans_message['.$url.']')
                                        ->textarea([
                                            'class'=>'form-control border-left-color '.$class,'rows' => 3,
                                        ])
                                        ->label($lang) ?>
                                    <?= $button?>
                                    <?php $i++; endforeach; ?>
                            </div>
                            <div class="form-group pull-right ">
                                <?= Html::submitButton($model->isNewRecord ? Yii::t('yii', 'Add') : Yii::t('yii', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <?php ActiveForm::end(); ?>

    </div>


