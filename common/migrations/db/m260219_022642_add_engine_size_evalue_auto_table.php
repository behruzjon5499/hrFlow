<?php

use yii\db\Migration;

class m260219_022642_add_engine_size_evalue_auto_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('evalue_auto', 'engine_size',$this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('evalue_auto', 'engine_size',$this->double());
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m260219_022642_add_engine_size_evalue_auto_table cannot be reverted.\n";

        return false;
    }
    */
}
