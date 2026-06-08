<?php

use yii\db\Migration;

class m251125_160143_add_type_has_detail_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('has_detail', 'type',$this->integer());
        $this->addColumn('repair_state', 'type',$this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m251125_160143_add_type_has_detail_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m251125_160143_add_type_has_detail_table cannot be reverted.\n";

        return false;
    }
    */
}
