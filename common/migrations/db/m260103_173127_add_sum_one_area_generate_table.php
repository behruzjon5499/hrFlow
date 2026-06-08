<?php

use yii\db\Migration;

class m260103_173127_add_sum_one_area_generate_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('evalue_generate', 'sum_one_area',$this->decimal(20,2));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m260103_173127_add_sum_one_area_generate_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m260103_173127_add_sum_one_area_generate_table cannot be reverted.\n";

        return false;
    }
    */
}
