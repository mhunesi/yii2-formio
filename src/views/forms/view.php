<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use mhunesi\formio\widgets\FormioWidget;
use mhunesi\formio\enum\StatusEnum;
use mhunesi\formio\enum\CookieTrackingEnum;

/* @var $this yii\web\View */
/* @var $model mhunesi\formio\models\Forms */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('formio', 'Forms'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="forms-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('formio', 'Submissions'), ['/formio/submissions/index', 'SubmissionsSearch' => ['form_id' => $model->id]], ['class' => 'btn btn-success']) ?>
        <?= Html::a(Yii::t('formio', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('formio', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('formio', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'status',
                'value' => function($model){
                    return StatusEnum::getLabel($model->status);
                }
            ],
            [
                'attribute' => 'cookie_tracking',
                'value' => function($model){
                    return CookieTrackingEnum::getLabel($model->cookie_tracking);
                }
            ],
            'name',
            [
                'attribute' => 'token',
                'format' => 'raw',
                'value' => function($model){
                    return Html::a($model->token,['survey/index','token' => $model->token],['target' => '_blank','data-pjax' => 0]);
                }
            ],
            'model',
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>

    <h4 class="text-center"> <?= $model->name ?> - Demo</h4>

    <?= FormioWidget::widget([
        'query' => $model->data,
        'action' => \yii\helpers\Url::to(['/formio/submissions/create','id' => $model->id]),
        'clientOptions' => [
            'readOnly' => false,
            'noAlerts' => false,
        ]
    ]) ?>

</div>
