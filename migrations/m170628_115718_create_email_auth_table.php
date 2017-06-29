<?php

use yii\db\Migration;

/** Handles the creation of table `email_auth` */
class m170628_115718_create_email_auth_table extends Migration {

    /** @inheritdoc */
    public function up() {
        $this->createTable('email_auth', [
            'user_id'                   => $this->integer()->unique(),
            'user_email'                => $this->string(50),
            'user_password_hash'        => $this->string(255),
        ]);

        $this->addForeignKey(
            'fk-email_auth-user_id',
            'email_auth',
            'user_id',
            'users',
            'id',
            'CASCADE'
        );
    }

    /** @inheritdoc */
    public function down() {
        $this->dropForeignKey(
            'fk-email_auth-user_id',
            'email_auth'
        );

        $this->dropTable('email_auth');
    }
}
