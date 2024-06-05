<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%track}}`.
 */
class m240520_085605_add_album_id_column_to_track_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%track}}', 'album_id', $this->integer());

        $this->createIndex('idx-track-album_id', '{{%track}}', 'album_id');

        $this->addForeignKey(
            'fk-track-album_id',
            '{{%track}}',
            'album_id',
            '{{%album}}',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-track-album_id', '{{%track}}');
        $this->dropIndex('idx-track-album_id', '{{%track}}');
        $this->dropColumn('{{%track}}', 'album_id');
    }
}
