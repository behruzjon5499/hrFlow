<?php

use yii\db\Migration;

class m260224_162125_add_estimated_price_home_auto_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('evalue_home', 'estimated_price',$this->decimal(20,2)->defaultValue(0));
        $this->addColumn('evalue_auto', 'estimated_price',$this->decimal(20,2)->defaultValue(0));
        $this->addColumn('evalue_equipment', 'estimated_price',$this->decimal(20,2)->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('evalue_home', 'estimated_price' );
        $this->dropColumn('evalue_auto', 'estimated_price' );
        $this->dropColumn('evalue_equipment', 'estimated_price' );
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m260224_162125_add_estimated_price_home_auto_table cannot be reverted.\n";

        return false;
    }
    */
}
