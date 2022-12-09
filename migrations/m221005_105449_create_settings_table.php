<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%settings}}`.
 */
class m221005_105449_create_settings_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%settings}}', [
            'id' => $this->primaryKey()->unsigned()->notNull(),
            'field' => $this->string(255),
            'value' => $this->string(255),
            'label' => $this->string(255),
        ]);

        $this->insert('{{%settings}}', [
            'field' => 'name',
            'label' => 'Название сайта',
        ]);

        $this->insert('{{%settings}}', [
            'field' => 'description',
            'label' => 'Описание сайта',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%settings}}');
    }
}
