<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel mhunesi\formio\models\search\FormsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('formio', 'Forms');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="forms-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('formio', 'Create Forms'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'status',
                'value' => function($model){
                    return Yii::t('formio',\mhunesi\formio\models\Forms::STATUS[$model->status]);
                }
            ],
            [
                'attribute' => 'name',
                'format' => 'raw',
                'value' => function($model){
                    return Html::a($model->name,['forms/view','id' => $model->id]);
                }
            ],
            [
                'attribute' => 'token',
                'format' => 'raw',
                'value' => function($model){
                    return Html::a($model->token,['survey/index','token' => $model->token],['target' => '_blank','data-pjax' => 0]);
                }
            ],
            'model',
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
