<?php

use yii\db\Migration;

class m251126_175745_add_title_evalue_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('evalue_home', 'title',$this->string());
        $this->addColumn('evalue_auto', 'title',$this->string());
        $this->addColumn('evalue_equipment', 'title',$this->string());
        $this->createIndex('idx-evalue_home-title', 'evalue_home', 'title');
        $this->createIndex('idx-evalue_auto-title', 'evalue_auto', 'title');
        $this->createIndex('idx-evalue_equipment-title', 'evalue_equipment', 'title');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m251126_175745_add_title_evalue_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m251126_175745_add_title_evalue_table cannot be reverted.\n";

        return false;
    }
    */
}
