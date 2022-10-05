<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%logs_admin}}`.
 */
class m221005_105407_create_logs_admin_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%logs_admin}}', [
            'id' => $this->primaryKey()->unsigned(),
            'user_id' => $this->integer()->unsigned()->notNull(),
            'place' => $this->string(255)->notNull(),
            'action' => $this->tinyInteger(1)->unsigned()->notNull(),
            'details' => $this->text(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%logs_admin}}');
    }
}
