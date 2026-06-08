<?php

use yii\db\Migration;

class m251223_143937_add_extra_auto_ids_repair_state_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('repair_state', 'extra_auto_ids',$this->json());
        $this->createIndex('idx-repair_state-extra_auto_ids', 'repair_state', 'extra_auto_ids');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m251223_143937_add_extra_auto_ids_repair_state_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m251223_143937_add_extra_auto_ids_repair_state_table cannot be reverted.\n";

        return false;
    }
    */
}
