<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%error}}`.
 */
class m260224_180132_create_error_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%error}}', [
            'id' => $this->primaryKey(),
            'message' => $this->json(),
            'created_at' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%error}}');
    }
}
