<?php

use mhunesi\formio\widgets\FormioWidget;
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Json;

/* @var $this yii\web\View */
/* @var $model mhunesi\formio\models\Submissions */

$this->title = Yii::$app->formatter->asDatetime($model->created_at);
$this->params['breadcrumbs'][] = ['label' => Yii::t('formio', 'Forms'), 'url' => ['forms/index']];
$this->params['breadcrumbs'][] = ['label' => $model->form->name, 'url' => ['forms/view','id' => $model->form->id]];
$this->params['breadcrumbs'][] = ['label' => Yii::t('formio', 'Submissions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="submissions-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
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
            'form.name',
            //'data',
            [
                'attribute' => 'data',
                'format' => 'html',
                'value' => function($model){
                    return Html::tag('pre',Json::encode($model->data,JSON_PRETTY_PRINT));
                }
            ],
            'created_at:datetime',
            'updated_at:datetime',
            'created_by',
            'updated_by',
        ],
    ]) ?>

    <h4 class="text-center"> <?= Yii::t('formio','Submission') ?></h4>
    <hr>

    <?= FormioWidget::widget([
        'query' => $model->form->data,
        'action' => \yii\helpers\Url::to(['/formio/submissions/update','id' => $model->id]),
        'submission' => $model->data,
        'clientOptions' => [
            'readOnly' => true
        ]
    ]) ?>

</div>
