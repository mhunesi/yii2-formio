<?php
namespace  mhunesi\formio;

use Yii;
use yii\i18n\MissingTranslationEvent;

/**
 * (developer comment)
 *
 * @link http://www.mustafaunesi.com.tr/
 * @copyright Copyright (c) 2020 Polimorf IO
 * @product PhpStorm.
 * @author : Mustafa Hayri ÜNEŞİ <mhunesi@gmail.com>
 * @date: 2020-04-10
 * @time: 13:33
 */

class Module extends \yii\base\Module
{
    public $defaultRoute = 'forms';

    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'mhunesi\formio\controllers';

    /**
     * @var string
     */
    public $userModel = 'app/models/User';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        $this->registerTranslations();
    }

    /**
     * Module Register Translate
     */
    public function registerTranslations()
    {
        if (!isset(Yii::$app->get('i18n')->translations['formio*'])) {
            Yii::$app->i18n->translations['formio*'] = [
                'class' => 'yii\i18n\PhpMessageSource',
                'sourceLanguage' => 'en-US',
                'basePath' =>  __DIR__ . '/messages',
                'fileMap' => [
                    'formio' => 'formio.php',
                    'formio/form' => 'form.php',
                ],
                'on missingTranslation' => [self::className(), 'handleMissingTranslation']
            ];
        }
    }

    public static function handleMissingTranslation(MissingTranslationEvent $event)
    {
        $event->translatedMessage = "@MISSING: {$event->category}.{$event->message} FOR LANGUAGE {$event->language} @";
    }
}