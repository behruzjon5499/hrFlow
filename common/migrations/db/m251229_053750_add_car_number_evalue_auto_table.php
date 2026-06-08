<?php

use yii\db\Migration;

class m251229_053750_add_car_number_evalue_auto_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('evalue_auto', 'auto_number',$this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m251229_053750_add_car_number_evalue_auto_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m251229_053750_add_car_number_evalue_auto_table cannot be reverted.\n";

        return false;
    }
    */
}
