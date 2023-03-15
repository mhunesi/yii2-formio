<?php
/**
 * (developer comment)
 *
 * @link http://www.mustafaunesi.com.tr/
 * @copyright Copyright (c) 2020 Polimorf IO
 * @product PhpStorm.
 * @author : Mustafa Hayri ÜNEŞİ <mhunesi@gmail.com>
 * @date: 2020-04-10
 * @time: 11:35
 */

namespace mhunesi\formio\assets;

use Yii;
use yii\web\AssetBundle;

class FormioAssets extends AssetBundle
{
    public $sourcePath = __DIR__.'/_bundle';

    public $css = [
        'formio.full.min.css',
    ];

    public $js = [
        'formio.full.min.js',
    ];
}