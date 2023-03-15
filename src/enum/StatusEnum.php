<?php

namespace mhunesi\formio\enum;
/**
 * (developer comment)
 *
 * @link http://www.mustafaunesi.com.tr/
 * @copyright Copyright (c) 2020 Polimorf IO
 * @product PhpStorm.
 * @author : Mustafa Hayri ÜNEŞİ <mhunesi@gmail.com>
 * @date: 12/21/20
 * @time: 11:22 AM
 */

use yii2mod\enum\helpers\BaseEnum;

class StatusEnum extends BaseEnum
{
    public static $messageCategory = 'formio';

    const INACTIVE = 0;
    const ACTIVE = 1;

    public static $list = [
        self::ACTIVE => 'Active',
        self::INACTIVE => 'Inactive',
    ];
}