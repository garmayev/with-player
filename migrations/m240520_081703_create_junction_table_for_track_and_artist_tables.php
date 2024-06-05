<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%track_artist}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%track}}`
 * - `{{%artist}}`
 */
class m240520_081703_create_junction_table_for_track_and_artist_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%track_artist}}', [
            'track_id' => $this->integer(),
            'artist_id' => $this->integer(),
            'PRIMARY KEY(track_id, artist_id)',
        ]);

        // creates index for column `track_id`
        $this->createIndex(
            '{{%idx-track_artist-track_id}}',
            '{{%track_artist}}',
            'track_id'
        );

        // add foreign key for table `{{%track}}`
        $this->addForeignKey(
            '{{%fk-track_artist-track_id}}',
            '{{%track_artist}}',
            'track_id',
            '{{%track}}',
            'id',
            'CASCADE'
        );

        // creates index for column `artist_id`
        $this->createIndex(
            '{{%idx-track_artist-artist_id}}',
            '{{%track_artist}}',
            'artist_id'
        );

        // add foreign key for table `{{%artist}}`
        $this->addForeignKey(
            '{{%fk-track_artist-artist_id}}',
            '{{%track_artist}}',
            'artist_id',
            '{{%artist}}',
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
            '{{%fk-track_artist-track_id}}',
            '{{%track_artist}}'
        );

        // drops index for column `track_id`
        $this->dropIndex(
            '{{%idx-track_artist-track_id}}',
            '{{%track_artist}}'
        );

        // drops foreign key for table `{{%artist}}`
        $this->dropForeignKey(
            '{{%fk-track_artist-artist_id}}',
            '{{%track_artist}}'
        );

        // drops index for column `artist_id`
        $this->dropIndex(
            '{{%idx-track_artist-artist_id}}',
            '{{%track_artist}}'
        );

        $this->dropTable('{{%track_artist}}');
    }
}
