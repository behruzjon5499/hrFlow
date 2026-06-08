<?php

use yii\db\Migration;

class m251214_170633_add_extra_ids_building_materials_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('building_material', 'extra_ids',$this->json());
        $this->addColumn('repair_state', 'extra_ids',$this->json());
        $this->addColumn('home_plan', 'extra_ids',$this->json());
        $this->addColumn('auto_type', 'extra_ids',$this->json());
        $this->addColumn('auto_marka', 'extra_ids',$this->json());
        $this->addColumn('auto_model', 'extra_ids',$this->json());
        $this->addColumn('body_type', 'extra_ids',$this->json());
        $this->createIndex('idx-building_material-extra_ids', 'building_material', 'extra_ids');
        $this->createIndex('idx-repair_state-extra_ids', 'repair_state', 'extra_ids');
        $this->createIndex('idx-home_plan-extra_ids', 'home_plan', 'extra_ids');
        $this->createIndex('idx-auto_type-extra_ids', 'auto_type', 'extra_ids');
        $this->createIndex('idx-auto_marka-extra_ids', 'auto_marka', 'extra_ids');
        $this->createIndex('idx-auto_model-extra_ids', 'auto_model', 'extra_ids');
        $this->createIndex('idx-body_type-extra_ids', 'body_type', 'extra_ids');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m251214_170633_add_extra_ids_building_materials_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m251214_170633_add_extra_ids_building_materials_table cannot be reverted.\n";

        return false;
    }
    */
}
