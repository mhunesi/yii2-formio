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

use Yii;
use yii\web\Cookie;
use yii\web\Controller;
use mhunesi\formio\Module;
use mhunesi\formio\models\Forms;
use yii\web\NotFoundHttpException;
use mhunesi\formio\traits\FormioTrait;
use mhunesi\formio\models\Submissions;
use mhunesi\formio\enum\CookieTrackingEnum;

class SurveyController extends Controller
{
    use FormioTrait;

    public $layout = 'survey';

    public function actionIndex($token)
    {
        $form = $this->findModel($token);

        /** @var Module $module */
        $module = $this->module;

        if((int)$form->cookie_tracking === CookieTrackingEnum::ACTIVE &&
            Yii::$app->request->cookies->getValue($module->cookieName. "_{$form->id}"))
        {
            return $this->redirect(['thanks','token' => $token]);
        }

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

        /** @var Module $module */
        $module = $this->module;

        if((int)$form->cookie_tracking === CookieTrackingEnum::ACTIVE){
            Yii::$app->response->cookies->add(new Cookie([
                'name' => $module->cookieName. "_{$form->id}",
                'value' => true,
                'expire' => time() + $module->cookieExpireTime,
                'path' => $this->getUniqueId()
            ]));
        }

        return $this->render('thanks',[
            'form' => $form
        ]);
    }

    protected function findModel($token)
    {
        if (($model = Forms::find()->active()->notDeleted()->token($token)->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}