<?php

use yii\db\Migration;

/** Handles the creation of table `users` */
class m170624_192157_create_users_table extends Migration {

    /** @inheritdoc */
    public function up() {
        $this->createTable('users', [
            'id' => $this->primaryKey()
        ]);
    }

    /** @inheritdoc */
    public function down() {
        $this->dropTable('users');
    }
}
