<?php

use yii\db\Migration;
use app\modules\page\models\Page;

/**
 * Handles the creation of table `{{%page}}`.
 */
class m221005_105435_create_page_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%page}}', [
            'id' => $this->primaryKey()->unsigned(),
            'name' => $this->string(50)->notNull(),
            'urn' => $this->string(50)->notNull(),
            'redirect' => $this->string(50),
            'meta_title' => $this->string(60),
            'meta_description' => $this->string(150),
            'meta_image' => $this->integer()->unsigned(),
            'active' => $this->tinyInteger(1)->unsigned(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
        ]);

        $datetime = date('Y-m-d H:i:s');

        $this->insert('{{%page}}', [
            'name' => 'Главная',
            'urn' => Page::MAIN_PAGE,
            'active' => true,
            'created_at' => $datetime,
            'updated_at' => $datetime,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%page}}');
    }
}
