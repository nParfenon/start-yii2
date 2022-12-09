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
            'urn' => $this->string(50)->notNull()->unique(),
            'redirect' => $this->string(50),
            'meta_title' => $this->string(60),
            'meta_description' => $this->string(150),
            'meta_image' => $this->integer()->unsigned(),
            'active' => $this->tinyInteger(1)->unsigned(),
            'created_at' => $this->timestamp(),
            'updated_at' => $this->timestamp(),
        ]);

        $timestamp = date('Y-m-d H:i:s');

        $this->insert('{{%page}}', [
            'name' => 'Главная',
            'urn' => Page::MAIN_PAGE,
            'active' => true,
            'created_at' => $timestamp,
            'updated_at' => $timestamp,
        ]);

        $this->insert('{{%page}}', [
            'name' => 'Авторизация',
            'urn' => '/login',
            'active' => true,
            'created_at' => $timestamp,
            'updated_at' => $timestamp,
        ]);

        $this->insert('{{%page}}', [
            'name' => 'Регистрация',
            'urn' => '/register',
            'active' => true,
            'created_at' => $timestamp,
            'updated_at' => $timestamp,
        ]);

        $this->insert('{{%page}}', [
            'name' => 'Восстановить пароль',
            'urn' => '/reset-password',
            'active' => true,
            'created_at' => $timestamp,
            'updated_at' => $timestamp,
        ]);

        $this->insert('{{%page}}', [
            'name' => 'Установить пароль',
            'urn' => '/set-new-password',
            'active' => true,
            'created_at' => $timestamp,
            'updated_at' => $timestamp,
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
