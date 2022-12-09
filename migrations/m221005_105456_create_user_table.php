<?php

use yii\db\Migration;
use app\modules\user\models\User;

/**
 * Handles the creation of table `{{%user}}`.
 */
class m221005_105456_create_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey()->notNull()->unsigned(),
            'username' => $this->string(30)->notNull()->unique(),
            'email' => $this->string(255)->notNull()->unique(),
            'password' => $this->string(255)->notNull(),
            'password_reset_token' => $this->string(255),
            'authKey' => $this->string(255),
            'isAdmin' => $this->tinyInteger(1)->unsigned(),
            'created_at' => $this->timestamp(),
            'updated_at' => $this->timestamp(),
        ]);

        $this->addForeignKey(
            'user_id_fkidx',
            $this->db->tablePrefix.'log_admin',
            'user_id',
            $this->db->tablePrefix.'user',
            'id',
            'SET NULL'
        );

        $user = new User();

        $timestamp = date('Y-m-d H:i:s');

        $this->insert('{{%user}}', [
            'username' => $user::_SUPER_ADMIN,
            'email' => 'admin@email.ru',
            'password' => $user->setPassword($user::_SUPER_ADMIN),
            'isAdmin' => true,
            'created_at' => $timestamp,
            'updated_at' => $timestamp,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user}}');
    }
}
