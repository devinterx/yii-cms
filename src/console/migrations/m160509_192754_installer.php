<?php

use yii\db\Migration;

class m160509_192754_installer extends Migration
{
    public function up()
    {
        $this->createTable('{{%modules}}', [
            'id' => $this->primaryKey(),
            'folder' => $this->string()->notNull(),
            'title' => $this->string()->notNull(),
            'version' => $this->string()->notNull(),
            'image_id' => $this->integer(11),
            'status' => $this->integer(3)->notNull(),
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime()->notNull()
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%modules}}');
    }
}
