<?php

use yii\db\Migration;

/**
 * Handles the creation of table `user_profile`.
 */
class m170703_122608_create_user_profile_table extends Migration {

    /** @inheritdoc */
    public function up() {
        $this->createTable('user_profile', [
            'user_id'       => $this->integer()->unique(),
            'user_name'     => $this->string(255)->notNull(),
        ]);

        $this->addForeignKey(
            'fk-user_profile-user_id',
            'user_profile',
            'user_id',
            'users',
            'id',
            'CASCADE'
        );
    }

    /** @inheritdoc */
    public function down() {
        $this->dropForeignKey(
            'fk-user_profile-user_id',
            'user_profile'
        );

        $this->dropTable('user_profile');
    }
}
