<?php
/**
 * (developer comment)
 *
 * @link http://www.mustafaunesi.com.tr/
 * @copyright Copyright (c) 2020 Polimorf IO
 * @product PhpStorm.
 * @author : Mustafa Hayri ÜNEŞİ <mhunesi@gmail.com>
 * @date: 2020-04-28
 * @time: 00:24
 *
 * @var $form \mhunesi\formio\models\Forms
 * @var $this \yii\web\View
 */
$this->title = $form->name;
?>
<?= $form->render([
    'submission' => Yii::$app->request->get(),
    'action' => '',
    'thanksPage' => \yii\helpers\Url::to(['survey/thanks', 'token' => $form->token])
]) ?>
