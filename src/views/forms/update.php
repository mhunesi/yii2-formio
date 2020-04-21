<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model mhunesi\formio\models\Forms */

$this->title = Yii::t('formio', 'Update Forms: {name}', [
    'name' => $model->name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('formio', 'Forms'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('formio', 'Update');

?>
<div class="forms-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
