<?php

use yii\db\Migration;

/**
 * Class m201218_115704_formio_cookie_field_added
 */
class m201218_115704_formio_cookie_field_added extends Migration
{
    public $tableName = 'formio_forms';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn($this->tableName,'cookie_tracking',$this->boolean()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn($this->tableName,'cookie_tracking');

        return true;
    }
}
