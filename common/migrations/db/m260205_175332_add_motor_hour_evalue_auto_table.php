<?php

use yii\db\Migration;

class m260205_175332_add_motor_hour_evalue_auto_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('evalue_auto', 'motor_hour',$this->double());
        $this->addColumn('evalue_auto', 'lifting_capacity',$this->double());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m260205_175332_add_motor_hour_evalue_auto_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m260205_175332_add_motor_hour_evalue_auto_table cannot be reverted.\n";

        return false;
    }
    */
}
