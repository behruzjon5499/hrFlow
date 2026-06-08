<?php

use yii\db\Migration;

class m251214_175903_add_extra_ids_facade_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('facade', 'extra_ids',$this->json());
        $this->createIndex('idx-facade-extra_ids', 'facade', 'extra_ids');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m251214_175903_add_extra_ids_facade_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m251214_175903_add_extra_ids_facade_table cannot be reverted.\n";

        return false;
    }
    */
}
