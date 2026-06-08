<?php

use yii\db\Migration;

class m260106_113203_add_uid_neigboorhood_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('neighborhood', 'region_code',$this->string());
        $this->addColumn('neighborhood', 'district_code',$this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m260106_113203_add_uid_neigboorhood_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m260106_113203_add_uid_neigboorhood_table cannot be reverted.\n";

        return false;
    }
    */
}
