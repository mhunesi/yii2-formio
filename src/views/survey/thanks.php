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

$asset = \mhunesi\formio\assets\FormioAssets::register($this);
?>

<div class="survey-head text-center pt-4">
    <img class="mb-4" width="80" src="<?= $asset->baseUrl.'/img/tick.png' ?>">
    <h4 class="text-center"><?= Yii::t('formio','Thanks For Submission') ?>.</h4>
</div>