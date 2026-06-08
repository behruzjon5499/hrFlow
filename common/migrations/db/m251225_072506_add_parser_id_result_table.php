<?php

use yii\db\Migration;

class m251225_072506_add_parser_id_result_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('evalue_home_result', 'parser_home_id',$this->integer());
        $this->addColumn('evalue_auto_result', 'parser_auto_id',$this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m251225_072506_add_parser_id_result_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m251225_072506_add_parser_id_result_table cannot be reverted.\n";

        return false;
    }
    */
}
