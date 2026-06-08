<?php

use yii\db\Migration;

class m251214_160452_add_extra_ids_region_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('region', 'extra_ids',$this->json());
        $this->addColumn('district', 'extra_ids',$this->json());
        $this->createIndex('idx-region-extra_ids', 'region', 'extra_ids');
        $this->createIndex('idx-district-extra_ids', 'district', 'extra_ids');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m251214_160452_add_extra_ids_region_table cannot be reverted.\n";

        return false;
    }
    */
}
