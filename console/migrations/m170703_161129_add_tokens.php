<?php

use yii\db\Migration;

class m170703_161129_add_tokens extends Migration
{
    public function safeUp()
    {
        $this->createTable('tokens', [
            'id' => $this->primaryKey(),
            'access_token' => $this->text()->null(),
            'refresh_token' => $this->text()->null()
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('tokens');
    }
}
