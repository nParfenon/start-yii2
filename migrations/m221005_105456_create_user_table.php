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
            'id' => $this->primaryKey()->unsigned(),
            'username' => $this->string(30)->notNull(),
            'email' => $this->string(255)->notNull(),
            'phone' => $this->string(40),
            'password' => $this->string(255)->notNull(),
            'password_reset_token' => $this->string(255),
            'authKey' => $this->string(255),
            'isAdmin' => $this->tinyInteger(1)->unsigned(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
        ]);

        $user = new User();

        $datetime = date('Y-m-d H:i:s');

        $this->insert('{{%user}}', [
            'username' => $user::SUPER_ADMIN,
            'email' => 'admin@email.ru',
            'password' => $user->setPassword($user::SUPER_ADMIN),
            'isAdmin' => true,
            'created_at' => $datetime,
            'updated_at' => $datetime,
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
