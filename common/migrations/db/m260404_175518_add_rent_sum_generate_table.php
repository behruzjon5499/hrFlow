<?php

use yii\db\Migration;

class m260404_175518_add_rent_sum_generate_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('evalue_generate', 'rent_sum',$this->decimal(20,2)->defaultValue(null));

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m260404_175518_add_rent_sum_generate_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m260404_175518_add_rent_sum_generate_table cannot be reverted.\n";

        return false;
    }
    */
}
