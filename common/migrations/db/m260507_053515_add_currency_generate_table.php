<?php

use yii\db\Migration;

class m260507_053515_add_currency_generate_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('evalue_generate', 'currency',$this->decimal(20,2)->defaultValue(null));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('evalue_generate', 'currency' );
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m260507_053515_add_currency_generate_table cannot be reverted.\n";

        return false;
    }
    */
}
