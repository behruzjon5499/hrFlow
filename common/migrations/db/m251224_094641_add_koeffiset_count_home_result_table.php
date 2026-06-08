<?php

use yii\db\Migration;

class m251224_094641_add_koeffiset_count_home_result_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('evalue_home_result', 'coefficient_count',$this->integer());
        $this->addColumn('evalue_auto_result', 'coefficient_count',$this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m251224_094641_add_koeffiset_count_home_result_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m251224_094641_add_koeffiset_count_home_result_table cannot be reverted.\n";

        return false;
    }
    */
}
