<?php

use yii\db\Migration;

/**
 * Handles the dropping of table `{{%column_title_evalue_auto}}`.
 */
class m260105_122354_drop_column_title_evalue_auto_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('evalue_auto', 'price' );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

    }
}
