<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel mhunesi\formio\models\search\SubmissionsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('formio', 'Submissions');
$this->params['breadcrumbs'][] = ['label' => Yii::t('formio', 'Forms'), 'url' => ['forms/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="submissions-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            [
                'attribute' => 'form_id',
                'format' => 'raw',
                'value' => function($model){
                    return Html::a($model->form->name,['forms/view','id' => $model->form->id]);
                }
            ],
            //'data',
            'created_at:datetime',
            'updated_at:datetime',
            //'created_by',
            //'updated_by',
            //'deleted',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
