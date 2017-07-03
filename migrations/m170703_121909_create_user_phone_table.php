<?php

use yii\db\Migration;

/**
 * Handles the creation of table `user_phone`.
 */
class m170703_121909_create_user_phone_table extends Migration {

    /** @inheritdoc */
    public function up() {
        $this->createTable('user_phone', [
            'user_id'                   => $this->integer()->unique(),
            'user_phone'                => $this->string(50)->notNull(),
        ]);

        $this->addForeignKey(
            'fk-user_phone-user_id',
            'user_phone',
            'user_id',
            'users',
            'id',
            'CASCADE'
        );
    }

    /** @inheritdoc */
    public function down() {
        $this->dropForeignKey(
            'fk-user_phone-user_id',
            'user_phone'
        );

        $this->dropTable('user_phone');
    }
}
