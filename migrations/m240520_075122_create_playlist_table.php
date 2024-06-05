<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%playlist}}`.
 */
class m240520_075122_create_playlist_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%playlist}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
            'created_at' => $this->integer(),
            'user_id' => $this->integer(),
        ]);
        $this->createIndex(
            '{{%idx-playlist-user_id}}',
            '{{%playlist}}',
            'user_id'
        );
        $this->addForeignKey(
            'fk-playlist-user_id',
            '{{%playlist}}',
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
        $this->dropForeignKey('fk-playlist-user_id', '{{%playlist}}');
        $this->dropIndex('idx-playlist-user_id', '{{%playlist}}');
        $this->dropTable('{{%playlist}}');
    }
}
