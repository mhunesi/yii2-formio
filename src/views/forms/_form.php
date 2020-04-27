<?php

use yii\helpers\Html;
use yii\helpers\Json;
use yii\widgets\ActiveForm;
use mhunesi\formio\widgets\FormioBuilderWidget;
use mhunesi\formio\models\Forms;
/* @var $this yii\web\View */
/* @var $model mhunesi\formio\models\Forms */
/* @var $form yii\widgets\ActiveForm */

if($model->data){
    $model->type = $model->data['display'] ?? null;
}

?>

<div class="forms-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'status')->radioList(Forms::STATUS) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'model')->textInput(['maxlenght' => true]) ?>

    <?= $form->field($model,'type')->dropDownList(['form' => 'Form','wizard' => 'Wizard']) ?>

    <?= $form->field($model, 'data')->widget(FormioBuilderWidget::className(),[

    ]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('formio', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
