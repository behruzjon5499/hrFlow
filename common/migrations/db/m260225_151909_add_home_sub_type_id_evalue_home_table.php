<?php

use yii\db\Migration;

class m260225_151909_add_home_sub_type_id_evalue_home_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('evalue_home', 'home_sub_type_id',$this->integer()->defaultValue(null));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('evalue_home', 'home_sub_type_id' );
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m260225_151909_add_home_sub_type_id_evalue_home_table cannot be reverted.\n";

        return false;
    }
    */
}
