<?php
/**
 * (developer comment)
 *
 * @link http://www.mustafaunesi.com.tr/
 * @copyright Copyright (c) 2020 Polimorf IO
 * @product PhpStorm.
 * @author : Mustafa Hayri ÜNEŞİ <mhunesi@gmail.com>
 * @date: 2020-04-28
 * @time: 00:20
 */

namespace mhunesi\formio\controllers;

use mhunesi\formio\models\Submissions;
use mhunesi\formio\traits\FormioTrait;
use Yii;
use mhunesi\formio\models\Forms;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class SurveyController extends Controller
{
    use FormioTrait;

    public $layout = 'survey';

    public function actionIndex($token)
    {
        $form = $this->findModel($token);

        $this->performFormioSave(new Submissions([
            'form_id' => $form->id,
        ]));

        return $this->render('index',[
            'form' => $form
        ]);
    }

    public function actionThanks($token)
    {
        $form = $this->findModel($token);

        return $this->render('thanks',[
            'form' => $form
        ]);
    }

    protected function findModel($token)
    {
        if (($model = Forms::find()->token($token)->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}