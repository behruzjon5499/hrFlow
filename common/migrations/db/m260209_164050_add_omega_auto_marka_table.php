<?php

use yii\db\Migration;

class m260209_164050_add_omega_auto_marka_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('auto_marka', 'omega_year',$this->double());
        $this->addColumn('auto_marka', 'omega_km',$this->double());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('auto_marka', 'omega_year');
        $this->dropColumn('auto_marka', 'omega_km');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m260209_164050_add_omega_auto_marka_table cannot be reverted.\n";

        return false;
    }
    */
}
