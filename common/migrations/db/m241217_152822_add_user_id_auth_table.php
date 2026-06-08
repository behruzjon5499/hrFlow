<?php

use yii\db\Migration;

/**
 * Class m241217_152822_add_user_id_auth_table
 */
class m241217_152822_add_user_id_auth_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('rbac_auth_assignment', 'user_id');
        $this->addColumn('rbac_auth_assignment', 'user_id',$this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('rbac_auth_assignment', 'user_id');
        $this->addColumn('rbac_auth_assignment', 'user_id',$this->string());
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241217_152822_add_user_id_auth_table cannot be reverted.\n";

        return false;
    }
    */
}
