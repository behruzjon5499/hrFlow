<?php

use yii\db\Migration;

class m260222_155801_add_order_type_images_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('type_image', 'order',$this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('type_images', 'order' );
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m260222_155801_add_order_type_images_table cannot be reverted.\n";

        return false;
    }
    */
}
