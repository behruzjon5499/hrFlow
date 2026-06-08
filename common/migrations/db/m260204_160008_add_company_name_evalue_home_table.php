<?php

use yii\db\Migration;

class m260204_160008_add_company_name_evalue_home_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('evalue_home', 'company_name',$this->string());
        $this->addColumn('evalue_home', 'location_type',$this->integer());
        $this->addColumn('evalue_home', 'land_area',$this->string());
        $this->addColumn('evalue_home', 'ownership_right',$this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('evalue_home', 'company_name' );
        $this->dropColumn('evalue_home', 'location_type' );
        $this->dropColumn('evalue_home', 'land_area' );
        $this->dropColumn('evalue_home', 'ownership_right' );
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m260204_160008_add_company_name_evalue_home_table cannot be reverted.\n";

        return false;
    }
    */
}
