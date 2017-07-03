<?php

use yii\db\Migration;

/**
 * Handles the creation of table `user_name`.
 */
class m170703_122608_create_user_name_table extends Migration {

    /** @inheritdoc */
    public function up() {
        $this->createTable('user_name', [
            'user_id'       => $this->integer(),
            'provider'      => $this->string(255)->notNull(),
            'user_name'     => $this->string(255)->notNull(),
        ]);

        $this->createIndex(
            'user_id_and_provider',
            'user_name',
            ['user_id', 'provider'],
            true
        );

        $this->addForeignKey(
            'fk-user_name-user_id',
            'user_name',
            'user_id',
            'users',
            'id',
            'CASCADE'
        );
    }

    /** @inheritdoc */
    public function down() {
        $this->dropForeignKey(
            'fk-user_name-user_id',
            'user_name'
        );

        $this->dropTable('user_name');
    }
}
