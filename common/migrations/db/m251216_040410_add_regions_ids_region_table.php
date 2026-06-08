<?php

use yii\db\Migration;

class m251216_040410_add_regions_ids_region_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('region', 'extra_auto_region_ids',$this->json());
        $this->addColumn('district', 'extra_auto_district_ids',$this->json());
        $this->createIndex('idx-region-extra_auto_region_ids', 'region', 'extra_auto_region_ids');
        $this->createIndex('idx-district-extra_auto_district_ids', 'district', 'extra_auto_district_ids');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m251216_040410_add_regions_ids_region_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m251216_040410_add_regions_ids_region_table cannot be reverted.\n";

        return false;
    }
    */
}
