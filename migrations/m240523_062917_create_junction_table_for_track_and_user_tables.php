<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%track_user}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%track}}`
 * - `{{%user}}`
 */
class m240523_062917_create_junction_table_for_track_and_user_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%track_user}}', [
            'track_id' => $this->integer(),
            'user_id' => $this->integer(),
            'rating' => $this->float(),
            'favorite' => $this->integer(),
            'PRIMARY KEY(track_id, user_id)',
        ]);

        // creates index for column `track_id`
        $this->createIndex(
            '{{%idx-track_user-track_id}}',
            '{{%track_user}}',
            'track_id'
        );

        // add foreign key for table `{{%track}}`
        $this->addForeignKey(
            '{{%fk-track_user-track_id}}',
            '{{%track_user}}',
            'track_id',
            '{{%track}}',
            'id',
            'CASCADE'
        );

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-track_user-user_id}}',
            '{{%track_user}}',
            'user_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-track_user-user_id}}',
            '{{%track_user}}',
            'user_id',
            '{{%user}}',
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
            '{{%fk-track_user-track_id}}',
            '{{%track_user}}'
        );

        // drops index for column `track_id`
        $this->dropIndex(
            '{{%idx-track_user-track_id}}',
            '{{%track_user}}'
        );

        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-track_user-user_id}}',
            '{{%track_user}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-track_user-user_id}}',
            '{{%track_user}}'
        );

        $this->dropTable('{{%track_user}}');
    }
}
