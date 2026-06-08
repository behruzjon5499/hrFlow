<?php

use yii\db\Migration;

class m251225_142847_add_begin_percent_auto_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('evalue_home_result', 'begin_sum',$this->decimal(20,2));
        $this->addColumn('evalue_auto_result', 'begin_percent',$this->double());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m251225_142847_add_begin_percent_auto_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m251225_142847_add_begin_percent_auto_table cannot be reverted.\n";

        return false;
    }
    */
}
