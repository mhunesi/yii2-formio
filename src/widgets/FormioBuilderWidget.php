<?php


namespace mhunesi\formio\widgets;

use yii\web\View;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
use yii\widgets\InputWidget;
use mhunesi\formio\assets\FormioAssets;

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

class FormioBuilderWidget extends InputWidget
{
    public $options = [];

    public $clientOptions = [];
    /**
     * Renders the widget.
     */
    public function run()
    {
        FormioAssets::register($this->view);

        $this->value = Json::encode($this->model->{$this->attribute} ?? []);

        $this->setDefaultProperties();

        $this->options['id'] = $this->id;

        Html::removeCssClass($this->options,'form-control');

        $this->registerClientScript();

        //echo $this->renderInputHtml('hidden');

        echo Html::activeInput('hidden', $this->model, $this->attribute, [
            'value' => $this->value
        ]);

        return Html::tag('div','',$this->options);
    }

    public function registerClientScript()
    {
        $inputID = Html::getInputId($this->model,$this->attribute);

        $clientOptionsJson = Json::encode($this->clientOptions);

        $js = "
        window.onload = function(){ 
    
            window.builder_{$this->id} = new Formio.FormBuilder(document.getElementById('{$this->id}'), JSON.parse(String.raw`{$this->value}`), JSON.parse(String.raw`{$clientOptionsJson}`));
            
            
            var input = document.getElementById('{$inputID}');
            
            var setInputValue = function(){
                input.value = JSON.stringify(builder_{$this->id}.instance.schema);
            }  
            
            document.getElementById('forms-type').addEventListener('change', function() {
                builder_{$this->id}.setDisplay(this.value);
                setInputValue();
            })
          
            builder_{$this->id}.instance.ready.then(function(){
            
                builder_{$this->id}.instance.on('saveComponent', function(build){
                    setInputValue();
                });
            
                builder_{$this->id}.instance.on('editComponent', function(build){
                    setInputValue();
                });
            })
            
        }
         ";

        $this->view->registerJs($js,View::POS_END);
    }

    protected function setDefaultProperties()
    {
        $this->clientOptions = ArrayHelper::merge([
            'baseUrl' => Url::home(true),
            'projectUrl' => Url::home(true),
        ],$this->clientOptions);
    }
}