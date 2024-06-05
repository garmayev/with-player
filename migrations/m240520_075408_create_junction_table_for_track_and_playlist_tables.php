<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%track_playlist}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%track}}`
 * - `{{%playlist}}`
 */
class m240520_075408_create_junction_table_for_track_and_playlist_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%track_playlist}}', [
            'track_id' => $this->integer(),
            'playlist_id' => $this->integer(),
            'PRIMARY KEY(track_id, playlist_id)',
        ]);

        // creates index for column `track_id`
        $this->createIndex(
            '{{%idx-track_playlist-track_id}}',
            '{{%track_playlist}}',
            'track_id'
        );

        // add foreign key for table `{{%track}}`
        $this->addForeignKey(
            '{{%fk-track_playlist-track_id}}',
            '{{%track_playlist}}',
            'track_id',
            '{{%track}}',
            'id',
            'CASCADE'
        );

        // creates index for column `playlist_id`
        $this->createIndex(
            '{{%idx-track_playlist-playlist_id}}',
            '{{%track_playlist}}',
            'playlist_id'
        );

        // add foreign key for table `{{%playlist}}`
        $this->addForeignKey(
            '{{%fk-track_playlist-playlist_id}}',
            '{{%track_playlist}}',
            'playlist_id',
            '{{%playlist}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%track}}`
        $this->dropForeignKey(
            '{{%fk-track_playlist-track_id}}',
            '{{%track_playlist}}'
        );

        // drops index for column `track_id`
        $this->dropIndex(
            '{{%idx-track_playlist-track_id}}',
            '{{%track_playlist}}'
        );

        // drops foreign key for table `{{%playlist}}`
        $this->dropForeignKey(
            '{{%fk-track_playlist-playlist_id}}',
            '{{%track_playlist}}'
        );

        // drops index for column `playlist_id`
        $this->dropIndex(
            '{{%idx-track_playlist-playlist_id}}',
            '{{%track_playlist}}'
        );

        $this->dropTable('{{%track_playlist}}');
    }
}
