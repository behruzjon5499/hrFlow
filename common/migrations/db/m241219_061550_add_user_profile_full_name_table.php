<?php

use yii\db\Migration;

/**
 * Class m241219_061550_add_user_profile_full_name_table
 */
class m241219_061550_add_user_profile_full_name_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('user_profile', 'firstname');
        $this->dropColumn('user_profile', 'lastname');
        $this->dropColumn('user_profile', 'middlename');
        $this->dropColumn('user_profile', 'avatar_path');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m241219_061550_add_user_profile_full_name_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241219_061550_add_user_profile_full_name_table cannot be reverted.\n";

        return false;
    }
    */
}
