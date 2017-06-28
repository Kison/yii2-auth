<?php

use yii\db\Migration;

/** Handles the creation of table `social_auth` */
class m170628_115706_create_firebase_auth_table extends Migration {

    /** @inheritdoc */
    public function up() {
        $this->createTable('firebase_auth', [
            'user_id'                   => $this->integer()->unique(),
            'user_email'                => $this->string(50),
            'user_phone'                => $this->string(50),
            'user_name'                 => $this->string(255)->notNull(),
            'firebase_user_id'          => $this->string(255)->notNull(),
            'firebase_access_token'     => $this->string(255)->notNull(),
        ]);

        $this->addForeignKey(
            'fk-firebase_auth-user_id',
            'firebase_auth',
            'user_id',
            'users',
            'id',
            'CASCADE'
        );
    }

    /** @inheritdoc */
    public function down() {
        $this->dropForeignKey(
            'fk-firebase_auth-user_id',
            'firebase_auth'
        );
        $this->dropTable('firebase_auth');
    }
}
