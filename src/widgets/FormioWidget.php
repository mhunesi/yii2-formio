<?php


namespace mhunesi\formio\widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use mhunesi\formio\assets\FormioAssets;
use yii\helpers\Url;
use mhunesi\formio\i18n\PhpMessageSource;
use yii\web\View;
use mhunesi\formio\Module;

/**
 * (developer comment)
 *
 * @link http://www.mustafaunesi.com.tr/
 * @copyright Copyright (c) 2020 Polimorf IO
 * @product PhpStorm.
 * @author : Mustafa Hayri ÜNEŞİ <mhunesi@gmail.com>
 * @date: 2020-04-10
 * @time: 11:44
 */

class FormioWidget extends Widget
{
    public $query;

    public $action = '';

    public $options = [];

    public $clientOptions = [];

    public $submission;

    public $thanksPage;

    /**
     * Renders the widget.
     */
    public function run()
    {
        FormioAssets::register($this->view);

        $this->setDefaultProperties();

        $this->options['id'] = $this->id;

        $this->i18n();

        $this->registerClientScript();

        return Html::tag('div','',$this->options);
    }

    public function registerClientScript()
    {
        $clientOptionsJson = Json::encode($this->clientOptions);
        $queryJson = Json::encode($this->query);
        $submissionJson = Json::encode($this->submission);

        $this->view->registerJs("
        window.onload = function(){ 
             window.formio_{$this->id} = new Formio.createForm(document.getElementById('{$this->id}'), {$queryJson},{$clientOptionsJson})
             .then(function(form) {
                form.nosubmit = true;
                
                var submissionValue = {$submissionJson};
                var thanksPage = '{$this->thanksPage}';
                
                form.submission = {
                    data: submissionValue
                };

                form.on('submit', function(submission) {
                  return fetch('{$this->action}', {
                      method: 'POST',
                      body: JSON.stringify(submission),
                      headers: {
                        'X-CSRF-Token': document.querySelector('meta[name=\"csrf-token\"]').content
                      }
                    })
                    .then(response => {
                      return response.json();
                    }).then(e => {
                       if(e.status){ 
                        
                        if(!submissionValue){
                            form.resetValue();
                        }
                        
                        form.emit('submitDone', submission);
                        
                        if(thanksPage !== ''){
                            window.location = thanksPage;
                        }
                        
                       }else{
                       var formErrors = [];
                            
                            e.errors.data.forEach((errors) => {
                                Object.keys(errors).forEach((key) => {
                                    let error = {
                                            key : key,
                                            path : key,
                                            component : form.getComponent(key) ? form.getComponent(key).component : null,
                                            message : errors[key].join(','),
                                            external : true
                                    };
                                    
                                    formErrors.push(error);
                                    
                                    if(error.component)
                                    {
                                        let component = form.getComponent(error.key);
                                        component.addInputError(error.message,false,component.refs.input)
                                    }
                                  
                                })
                            })
                        
                        form.showErrors(formErrors);
                        form.emit('error', formErrors)
                        
                       }
                    })
                }); 
                
                 window.setLanguage = function(lang) {
                    form.language = lang;
                 };
            });
        }",View::POS_END);
    }

    protected function setDefaultProperties()
    {
        $this->clientOptions = ArrayHelper::merge([
            'baseUrl' => Url::home(true),
            'projectUrl' => Url::home(true),
        ],$this->clientOptions);
    }

    protected function i18n()
    {
        Yii::$app->getModule('formio')->registerTranslations();

        $messageSource = new PhpMessageSource();

        $lang = \Locale::getPrimaryLanguage(Yii::$app->language);

        $message = $messageSource->formMessages();

        $this->clientOptions = ArrayHelper::merge([
            'language' => $lang,
            'i18n' => [
                $lang => $message
            ]
        ],$this->clientOptions);

        $this->clientOptions;

    }
}