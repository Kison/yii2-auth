<?php

use yii\db\Migration;

/**
 * Handles the creation of table `user_email`.
 */
class m170703_121859_create_user_email_table extends Migration {

    /** @inheritdoc */
    public function up() {
        $this->createTable('user_email', [
            'user_id'                   => $this->integer()->unique(),
            'user_email'                => $this->string(50)->notNull()
        ]);

        $this->addForeignKey(
            'fk-user_email-user_id',
            'user_email',
            'user_id',
            'users',
            'id',
            'CASCADE'
        );
    }

    /** @inheritdoc */
    public function down() {
        $this->dropForeignKey(
            'fk-user_email-user_id',
            'user_email'
        );

        $this->dropTable('user_email');
    }
}
