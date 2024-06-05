<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%artist}}`.
 */
class m240520_074604_create_artist_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%artist}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'bio' => $this->text(),
            'born_date' => $this->integer(),
            'death_date' => $this->integer(),
            'created_at' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%artist}}');
    }
}
