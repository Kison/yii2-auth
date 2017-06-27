<?php

use yii\db\Migration;

/** Handles the creation of table `firebase` */
class m170627_181339_create_firebase_table extends Migration {

    /** @inheritdoc */
    public function up() {
        $this->createTable('firebase', [
            'user_id'                   => $this->integer()->unique(),
            'firebase_user_id'          => $this->string(255)->notNull(),
            'firebase_access_token'     => $this->string(255)->notNull()
        ]);

        $this->addForeignKey('fk_user_firebase', 'firebase', 'user_id', 'users', 'id', 'CASCADE');
    }

    /** @inheritdoc */
    public function down() {
        $this->dropTable('firebase');
    }
}
