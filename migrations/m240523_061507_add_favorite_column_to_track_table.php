<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%track}}`.
 */
class m240523_061507_add_favorite_column_to_track_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn("{{%track}}", "favorite", $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    }
}
