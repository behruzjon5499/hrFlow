<?php

use common\enums\UserEnum;
use yii\db\Migration;

class m140703_123000_user extends Migration
{
    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string(),
            'pinfl' => $this->string(14),
            'root_dep_id' => $this->integer(),
            'sub_dep_id' => $this->integer(),
            'auth_key' => $this->string(32)->notNull(),
            'access_token' => $this->string(255)->notNull(),
            'sso_access_token' => $this->string(255),
            'sso_id_token' => $this->string(255),
            'sso_refresh_token' => $this->string(255),
            'password_hash' => $this->string()->notNull(),
            'chat_id' => $this->integer(),
            'oauth_client' => $this->string(),
            'oauth_client_user_id' => $this->string(),
            'uuid' => $this->string(),
            'condition' => $this->string()->defaultValue('A'),
            'status' => $this->smallInteger()->notNull()->defaultValue(UserEnum::STATUS_ACTIVE),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'logged_at' => $this->integer(),
        ]);

        $this->createTable('{{%user_profile}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'emp_id' => $this->integer(),
            'firstname' => $this->string(),
            'middlename' => $this->string(),
            'lastname' => $this->string(),
            'avatar' => $this->string(),
            'pinfl' => $this->string(),
            'gender' => $this->smallInteger(1),
            'position' => $this->string(),
            'status' => $this->integer()->defaultValue(1)->notNull(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'deleted_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
            'deleted_by' => $this->integer(),
            'is_deleted' => $this->boolean()->defaultValue(false)->notNull(),
        ]);

        $this->addForeignKey('fk_user', '{{%user_profile}}', 'user_id', '{{%user}}', 'id', 'cascade', 'cascade');

    }

    /**
     * @return bool|void
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_user', '{{%user_profile}}');
        $this->dropTable('{{%user_profile}}');
        $this->dropTable('{{%user}}');

    }
}
