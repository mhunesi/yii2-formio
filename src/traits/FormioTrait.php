<?php
/**
 * (developer comment)
 *
 * @link http://www.mustafaunesi.com.tr/
 * @copyright Copyright (c) 2020 Polimorf IO
 * @product PhpStorm.
 * @author : Mustafa Hayri ÜNEŞİ <mhunesi@gmail.com>
 * @date: 2020-04-20
 * @time: 04:27
 */

namespace mhunesi\formio\traits;

use Yii;
use yii\helpers\Json;
use yii\web\Response;
use mhunesi\formio\models\Submissions;

trait FormioTrait
{

    protected function performFormioSave(Submissions $model)
    {
        if(Yii::$app->request->isPost){
            Yii::$app->response->format = Response::FORMAT_JSON;

            if ($model->load(Json::decode(Yii::$app->request->rawBody),'') && $model->save()) {
                Yii::$app->response->data = ['status' => true,'data' => $model->data];
            }else{
                Yii::$app->response->data = ['status' => !$model->hasErrors(),'errors' => $model->errors];
            }

            Yii::$app->response->send();
            Yii::$app->end();
        }
    }
}