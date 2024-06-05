<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%track}}`.
 */
class m240520_075101_create_track_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%track}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
            'thumb' => $this->string(),
            'url' => $this->string(),
            'length' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%track}}');
    }
}
