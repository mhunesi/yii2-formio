<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://github.com/yiisoft.png" height="100px">
    </a>
    <h1 align="center">Yii Formio Module</h1>
    <br>
</p>

The package bundle of [Form.io](https://github.com/formio/formio.js) plugin. Form.io is a plain JavaScript form renderer.

JavaScript powered Forms with JSON Form Builder https://formio.github.io/formio.js
 
[Examples](https://formio.github.io/formio.js/app/examples/) 


## Installation

Add the the package to your composer file:

```sh
composer require mhunesi/yii2-formio
```

The last thing you need to do is updating your database schema by applying the
migrations. Make sure that you have properly configured `db` application component
and run the following command:

```sh
    yii migrate --migrationPath=@mhunesi/formio/migrations
```

Add the modules to your application configuration file:

```php
'modules' => [
    // ...
    'formio' => [
        'class' => \mhunesi\formio\Module::class,
        'userModel' => 'app/models/User'
    ],
    // ...
]
```

## Usage

If you want Using Only Formio Widget:

```php
<?= FormioWidget::widget([
    'id' => 'example',
    'action' => Url::to(['example/create']),
    'thanksPage' => Url::to(['example/create']),
    'submission' => [
        'firstName' => 'Mustafa'
    ],
    'query' => [
        'components' => [
            [
                'type' => 'textfield',
                'key' => 'firstName',
                'label' => 'First Name',
                'placeholder' => 'Enter your first name.',
                'input' => true,
                'tooltip' => 'Enter your <strong>First Name</strong>',
                'description' => 'Enter your <strong>First Name</strong>',
            ],
            [
                'type' => 'button',
                'action'  => 'submit',
                'label' => 'Submit',
                'theme' => 'primary'
            ]
        ]
    ],
    'clientOptions' => [
        'hooks' => [
            'beforeSubmit' => new JsExpression("
                (submission, next) => {
                    if(confirm('Are you sure?')){
                        next();
                    }
                }"
            )
        ]
    ]

]) ?>
```

Or you can use Form.io Builder and:

```php
$form = Forms::findOne(8);

$form->render([
    'thanksPage' => Url::to(['example/thanks']),
]);
```



Screenshots
-----------

![screen-1](https://www.mustafaunesi.com.tr/uploads/2020/04/create-forms.png)

[All Screenshots](docs/screenshot.md)...

---

Built by [mhunesi](https://www.mustafaunesi.com.tr)

