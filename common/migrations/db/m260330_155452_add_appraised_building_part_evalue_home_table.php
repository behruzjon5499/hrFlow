<?php

use yii\db\Migration;

class m260330_155452_add_appraised_building_part_evalue_home_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('evalue_home', 'appraised_building_part',$this->string()->defaultValue(null));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m260330_155452_add_appraised_building_part_evalue_home_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m260330_155452_add_appraised_building_part_evalue_home_table cannot be reverted.\n";

        return false;
    }
    */
}
