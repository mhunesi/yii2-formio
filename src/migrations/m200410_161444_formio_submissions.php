<?php

use yii\db\Migration;

/**
 * Class m200410_161444_formio_submissions
 */
class m200410_161444_formio_submissions extends Migration
{
    public $tableName = 'formio_submissions';

    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable("{{%{$this->tableName}}}", [
            'id' => $this->primaryKey()->unsigned(),
            'form_id' => $this->integer()->unsigned(),
            'data' => $this->json()->comment('Submission Data'),
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

        if (!(Yii::$app->db->getTableSchema('{{%formio_forms}}', true) === null)) {
            $this->addForeignKey("{$this->tableName}_ibfk_3", "{{%{$this->tableName}}}", 'form_id', '{{%formio_forms}}', 'id', 'NO ACTION', 'NO ACTION');
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

        if (!(Yii::$app->db->getTableSchema('{{%formio_forms}}', true) === null))
        {
            $this->dropForeignKey(
                "{$this->tableName}_ibfk_3",
                "{{%{$this->tableName}}}"
            );
        }

        $this->dropTable("{{%{$this->tableName}}}");

        return true;
    }
}
