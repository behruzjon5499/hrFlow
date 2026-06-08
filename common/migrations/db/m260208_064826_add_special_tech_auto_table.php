<?php

use yii\db\Migration;

class m260208_064826_add_special_tech_auto_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('auto_type', 'is_special_tech',$this->boolean());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('auto_type', 'is_special_tech');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m260208_064826_add_special_tech_auto_table cannot be reverted.\n";

        return false;
    }
    */
}
