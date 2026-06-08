<?php

use yii\db\Migration;

/**
 * Class m241217_131516_add_user_gender_table
 */
class m241217_131516_add_user_gender_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('user', 'role_id', $this->string()->defaultValue(null));
        $this->addColumn('user', 'filial', $this->integer()->defaultValue(null));
        $this->addColumn('user_profile', 'phone', $this->string()->defaultValue(null));
        $this->addColumn('user_profile', 'partner_id', $this->string()->defaultValue(null));
        $this->addColumn('user_profile', 'birthday', $this->date()->defaultValue(null));
        $this->addColumn('user_profile', 'look_own_account', $this->boolean()->defaultValue(null));
        $this->addColumn('user_profile', 'is_assistant', $this->boolean()->defaultValue(null));
        $this->addColumn('user_profile', 'is_hr_plus', $this->boolean()->defaultValue(null));
        $this->addColumn('user_profile', 'is_change_password', $this->boolean()->defaultValue(null));
        $this->addColumn('user_profile', 'full_name', $this->string()->defaultValue(null));
        $this->dropColumn('user', 'email');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('user', 'role_id');
        $this->dropColumn('user', 'filial');
        $this->dropColumn('user_profile', 'phone');
        $this->dropColumn('user_profile', 'partner_id');
        $this->dropColumn('user_profile', 'birthday');
        $this->dropColumn('user_profile', 'look_own_account');
        $this->dropColumn('user_profile', 'is_assistant');
        $this->dropColumn('user_profile', 'is_hr_plus');
        $this->dropColumn('user_profile', 'is_change_password');
        $this->dropColumn('user_profile', 'lastname');
        $this->dropColumn('user_profile', 'middlename');
        $this->dropColumn('user_profile', 'firstname');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241217_131516_add_user_gender_table cannot be reverted.\n";

        return false;
    }
    */
}
