<?php

use yii\db\Migration;

class m251123_071423_add_fileable_id_file_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('file', 'fileable_id',$this->integer());
        $this->addColumn('file', 'fileable_type',$this->string());
        $this->createIndex('idx-file-fileable_id', 'file', 'fileable_id');
        $this->createIndex('idx-file-fileable_type', 'file', 'fileable_type');
        $this->createIndex('idx-file-type', 'file', 'type');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('file', 'fileable_id' );
        $this->dropColumn('file', 'fileable_type' );
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m251123_071423_add_fileable_id_file_table cannot be reverted.\n";

        return false;
    }
    */
}
