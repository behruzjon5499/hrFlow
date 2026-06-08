<?php

use yii\db\Migration;

class m260105_172620_add_is_electric_evalue_auto_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('auto_model', 'is_electric',$this->boolean()->defaultValue(false));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m260105_172620_add_is_electric_evalue_auto_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m260105_172620_add_is_electric_evalue_auto_table cannot be reverted.\n";

        return false;
    }
    */
}
