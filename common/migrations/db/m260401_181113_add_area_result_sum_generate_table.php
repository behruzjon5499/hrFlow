<?php

use yii\db\Migration;

class m260401_181113_add_area_result_sum_generate_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('evalue_generate', 'area_result_sum',$this->decimal(20,2)->defaultValue(null));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m260401_181113_add_area_result_sum_generate_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m260401_181113_add_area_result_sum_generate_table cannot be reverted.\n";

        return false;
    }
    */
}
