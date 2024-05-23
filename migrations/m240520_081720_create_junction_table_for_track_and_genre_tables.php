<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%track_genre}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%track}}`
 * - `{{%genre}}`
 */
class m240520_081720_create_junction_table_for_track_and_genre_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%track_genre}}', [
            'track_id' => $this->integer(),
            'genre_id' => $this->integer(),
            'PRIMARY KEY(track_id, genre_id)',
        ]);

        // creates index for column `track_id`
        $this->createIndex(
            '{{%idx-track_genre-track_id}}',
            '{{%track_genre}}',
            'track_id'
        );

        // add foreign key for table `{{%track}}`
        $this->addForeignKey(
            '{{%fk-track_genre-track_id}}',
            '{{%track_genre}}',
            'track_id',
            '{{%track}}',
            'id',
            'CASCADE'
        );

        // creates index for column `genre_id`
        $this->createIndex(
            '{{%idx-track_genre-genre_id}}',
            '{{%track_genre}}',
            'genre_id'
        );

        // add foreign key for table `{{%genre}}`
        $this->addForeignKey(
            '{{%fk-track_genre-genre_id}}',
            '{{%track_genre}}',
            'genre_id',
            '{{%genre}}',
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
            '{{%fk-track_genre-track_id}}',
            '{{%track_genre}}'
        );

        // drops index for column `track_id`
        $this->dropIndex(
            '{{%idx-track_genre-track_id}}',
            '{{%track_genre}}'
        );

        // drops foreign key for table `{{%genre}}`
        $this->dropForeignKey(
            '{{%fk-track_genre-genre_id}}',
            '{{%track_genre}}'
        );

        // drops index for column `genre_id`
        $this->dropIndex(
            '{{%idx-track_genre-genre_id}}',
            '{{%track_genre}}'
        );

        $this->dropTable('{{%track_genre}}');
    }
}
