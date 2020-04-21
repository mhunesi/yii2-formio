<?php

use yii\db\Migration;

/**
 * Class m200410_104352_formio_forms
 */
class m200410_104352_formio_forms extends Migration
{
    public $tableName = 'formio_forms';

    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable("{{%{$this->tableName}}}", [
            'id' => $this->primaryKey()->unsigned(),
            'status' => $this->boolean()->defaultValue('1')->comment('Status'),
            'name' => $this->string(255)->comment('Name'),
            'token' => $this->string(255)->comment('Token'),
            'model' => $this->string(255)->comment('Model Class Name'),
            'data' => $this->json()->comment('Form Data'),
            'created_at' => $this->integer()->comment('Created Date'),
            'updated_at' => $this->integer()->comment('Updated Date'),
            'created_by' => $this->integer()->comment('Created By'),
            'updated_by' => $this->integer()->comment('Updated By'),
            'deleted' => $this->tinyInteger(1)->defaultValue('0')->comment('Is Deleted'),
        ], $tableOptions);

        if (!(Yii::$app->db->getTableSchema('{{%user}}', true) === null)) {
            $this->addForeignKey("{$this->tableName}_ibfk_1", "{{%{$this->tableName}}}", 'created_by', '{{%user}}', 'id', 'NO ACTION', 'NO ACTION');
            $this->addForeignKey("{$this->tableName}_ibfk_2", "{{%{$this->tableName}}}", 'updated_by', '{{%user}}', 'id', 'NO ACTION', 'NO ACTION');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        if (!(Yii::$app->db->getTableSchema('{{%user}}', true) === null)) {
            $this->dropForeignKey(
                "{$this->tableName}_ibfk_1",
                "{{%{$this->tableName}}}"
            );
            $this->dropForeignKey(
                "{$this->tableName}_ibfk_2",
                "{{%{$this->tableName}}}"
            );
        }

        $this->dropTable("{{%{$this->tableName}}}");
    }
}
