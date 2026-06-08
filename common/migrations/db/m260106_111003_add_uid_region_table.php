<?php

use yii\db\Migration;

class m260106_111003_add_uid_region_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('region', 'uid',$this->string());
        $this->addColumn('district', 'uid',$this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m260106_111003_add_uid_region_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m260106_111003_add_uid_region_table cannot be reverted.\n";

        return false;
    }
    */
}
