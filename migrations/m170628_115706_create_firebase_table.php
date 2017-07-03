<?php

use yii\db\Migration;

/** Handles the creation of table `social_auth` */
class m170628_115706_create_firebase_table extends Migration {

    /** @inheritdoc */
    public function up() {
        $this->createTable('firebase', [
            'user_id'                   => $this->integer()->unique(),
            'firebase_user_id'          => $this->string(255)->notNull(),
            'firebase_access_token'     => $this->string(255)->notNull(),
        ]);

        $this->addForeignKey(
            'fk-firebase-user_id',
            'firebase',
            'user_id',
            'users',
            'id',
            'CASCADE'
        );
    }

    /** @inheritdoc */
    public function down() {
        $this->dropForeignKey(
            'fk-firebase-user_id',
            'firebase'
        );
        $this->dropTable('firebase');
    }
}
