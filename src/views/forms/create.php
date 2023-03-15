<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model mhunesi\formio\models\Forms */

$this->title = Yii::t('formio', 'Create Forms');
$this->params['breadcrumbs'][] = ['label' => Yii::t('formio', 'Forms'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="forms-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
