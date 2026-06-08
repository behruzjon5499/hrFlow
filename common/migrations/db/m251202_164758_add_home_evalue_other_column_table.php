<?php

use yii\db\Migration;

class m251202_164758_add_home_evalue_other_column_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('evalue_home', 'has_ownership',$this->boolean());
        $this->addColumn('evalue_home', 'neighborhood_id',$this->integer());
        $this->addColumn('evalue_home', 'usable_area',$this->double());
        $this->addColumn('evalue_home', 'completion_percent',$this->double());
        $this->addColumn('evalue_home', 'facade_id',$this->integer());
        $this->addColumn('evalue_auto', 'neighborhood_id',$this->integer());
        $this->addColumn('evalue_auto', 'address',$this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m251202_164758_add_home_evalue_other_column_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m251202_164758_add_home_evalue_other_column_table cannot be reverted.\n";

        return false;
    }
    */
}
