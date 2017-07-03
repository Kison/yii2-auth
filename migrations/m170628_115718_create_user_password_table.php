<?php

use yii\db\Migration;

/** Handles the creation of table `user_password` */
class m170628_115718_create_user_password_table extends Migration {

    /** @inheritdoc */
    public function up() {
        $this->createTable('user_password', [
            'user_id'                   => $this->integer()->unique(),
            'user_password_hash'        => $this->string(255),
        ]);

        $this->addForeignKey(
            'fk-user_password-user_id',
            'user_password',
            'user_id',
            'users',
            'id',
            'CASCADE'
        );
    }

    /** @inheritdoc */
    public function down() {
        $this->dropForeignKey(
            'fk-user_password-user_id',
            'user_password'
        );

        $this->dropTable('user_password');
    }
}
