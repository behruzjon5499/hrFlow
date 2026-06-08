<?php

use yii\db\Migration;

class m260209_172622_add_body_number_evalue_auto_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('evalue_auto', 'tech_passport_seria',$this->string());
        $this->addColumn('evalue_auto', 'tech_passport_date',$this->string());
        $this->addColumn('evalue_auto', 'body_color',$this->string());
        $this->addColumn('evalue_auto', 'body_number',$this->string());
        $this->addColumn('evalue_auto', 'engine_number',$this->string());
        $this->addColumn('evalue_auto', 'chassis_number',$this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('evalue_auto', 'tech_passport_seria');
        $this->dropColumn('evalue_auto', 'tech_passport_date');
        $this->dropColumn('evalue_auto', 'body_color');
        $this->dropColumn('evalue_auto', 'body_number');
        $this->dropColumn('evalue_auto', 'engine_number');
        $this->dropColumn('evalue_auto', 'chassis_number');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m260209_172622_add_body_number_evalue_auto_table cannot be reverted.\n";

        return false;
    }
    */
}
