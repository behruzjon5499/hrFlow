<?php

use yii\db\Migration;

class m251203_114501_add_region_id_evalue_auto_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->addColumn('evalue_auto', 'region_id',$this->integer());
        $this->addColumn('evalue_auto', 'district_id',$this->integer());
        $this->createIndex('idx-evalue_auto-region_id', 'evalue_auto', 'region_id');
        $this->createIndex('idx-evalue_auto-district_id', 'evalue_auto', 'district_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m251203_114501_add_region_id_evalue_auto_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m251203_114501_add_region_id_evalue_auto_table cannot be reverted.\n";

        return false;
    }
    */
}
