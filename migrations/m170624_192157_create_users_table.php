<?php

use yii\db\Migration;

/** Handles the creation of table `users` */
class m170624_192157_create_users_table extends Migration {

    /** @inheritdoc */
    public function up() {
        $this->createTable('users', [
            'id'            => $this->primaryKey(),
            'login_method'  => "ENUM('facebook', 'twitter', 'email', 'phone')",
            'auth_key'      => $this->string(32)->notNull(),
            'access_token'  => $this->string(32)->notNull(),
            'time_created'  => "TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP"
        ]);
    }

    /** @inheritdoc */
    public function down() {
        $this->dropTable('users');
    }
}
