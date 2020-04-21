<?php

use yii\helpers\Html;
use mhunesi\formio\widgets\FormioWidget;

/* @var $this yii\web\View */
/* @var $model mhunesi\formio\models\Submissions */

$this->title = Yii::t('formio', 'Update Submissions: {name}', [
    'name' => $model->id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('formio', 'Forms'), 'url' => ['forms/index']];
$this->params['breadcrumbs'][] = ['label' => $model->form->name, 'url' => ['forms/view','id' => $model->form->id]];
$this->params['breadcrumbs'][] = ['label' => Yii::t('formio', 'Submissions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('formio', 'Update');
?>
<div class="submissions-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= FormioWidget::widget([
        'query' => $model->form->data,
        'action' => \yii\helpers\Url::to(['/formio/submissions/update','id' => $model->id]),
        'submission' => $model->data,
        'clientOptions' => [
            'readOnly' => false,
            'noAlerts' => false,
        ]
    ]) ?>

</div>
