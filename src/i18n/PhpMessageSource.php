<?php
/**
 * (developer comment)
 *
 * @link http://www.mustafaunesi.com.tr/
 * @copyright Copyright (c) 2020 Polimorf IO
 * @product PhpStorm.
 * @author : Mustafa Hayri ÜNEŞİ <mhunesi@gmail.com>
 * @date: 2020-04-20
 * @time: 06:43
 */

namespace mhunesi\formio\i18n;

use Yii;

class PhpMessageSource extends \yii\i18n\PhpMessageSource
{
    public function formMessages()
    {
        $messageSource = Yii::$app->i18n->getMessageSource('formio/form');

        if($messageSource instanceof \yii\i18n\PhpMessageSource){
            $this->basePath = $messageSource->basePath;
            $this->fileMap = $messageSource->fileMap;

           return $this->loadMessages('formio/form',Yii::$app->language);
        }
        return [];
    }

}