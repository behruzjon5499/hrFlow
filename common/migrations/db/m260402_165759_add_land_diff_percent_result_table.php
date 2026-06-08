<?php

use yii\db\Migration;

class m260402_165759_add_land_diff_percent_result_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('evalue_home_result', 'land_diff_percent',$this->string()->defaultValue(null));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m260402_165759_add_land_diff_percent_result_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m260402_165759_add_land_diff_percent_result_table cannot be reverted.\n";

        return false;
    }
    */
}
