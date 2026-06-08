<?php

use yii\db\Migration;

class m251122_155732_add_user_data_profile_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('user', 'oauth_client' );
        $this->dropColumn('user', 'filial' );
        $this->dropColumn('user', 'company_id' );
        $this->dropColumn('user', 'oauth_client_user_id' );
        $this->dropColumn('user_profile', 'partner_id' );
        $this->dropColumn('user_profile', 'look_own_account' );
        $this->dropColumn('user_profile', 'is_assistant' );
        $this->dropColumn('user_profile', 'is_hr_plus' );
        $this->dropColumn('user_profile', 'is_change_password' );
        $this->addColumn('user_profile', 'passport',$this->string());
        $this->addColumn('user_profile', 'pnfl',$this->string());
        $this->addColumn('user_profile', 'position',$this->string());
        $this->addColumn('user_profile', 'mfo',$this->string());
        $this->addColumn('user_profile', 'address',$this->string());
        $this->addColumn('user', 'email',$this->string());

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m251122_155732_add_user_data_profile_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m251122_155732_add_user_data_profile_table cannot be reverted.\n";

        return false;
    }
    */
}
