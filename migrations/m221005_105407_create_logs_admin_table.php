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
        $this->createTable('{{%log_admin}}', [
            'id' => $this->primaryKey()->notNull()->unsigned(),
            'user_id' => $this->integer()->unsigned(),
            'place' => $this->string(255)->notNull(),
            'action' => $this->tinyInteger(1)->notNull()->unsigned(),
            'details' => $this->json()->notNull(),
            'created_at' => $this->timestamp(),
            'updated_at' => $this->timestamp(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%log_admin}}');
    }
}
