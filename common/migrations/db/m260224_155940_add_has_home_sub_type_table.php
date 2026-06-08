<?php

use yii\db\Migration;

class m260224_155940_add_has_home_sub_type_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('home_type', 'has_home_sub_type',$this->boolean()->defaultValue(false));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('home_type', 'has_home_sub_type' );
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m260224_155940_add_has_home_sub_type_table cannot be reverted.\n";

        return false;
    }
    */
}
