<?php

use yii\db\Migration;

class m260106_054550_add_fuel_type_id_engine_size_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('engine_size', 'fuel_type_ids',$this->json());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m260106_054550_add_fuel_type_id_engine_size_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m260106_054550_add_fuel_type_id_engine_size_table cannot be reverted.\n";

        return false;
    }
    */
}
