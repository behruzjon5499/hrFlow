<?php

use yii\db\Migration;

class m260513_024005_add_description_generate_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('evalue_generate', 'description',$this->text()->defaultValue(null));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('evalue_generate', 'description' );
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m260513_024005_add_description_generate_table cannot be reverted.\n";

        return false;
    }
    */
}
