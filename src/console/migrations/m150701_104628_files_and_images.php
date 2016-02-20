<?php

use yii\db\Schema;
use yii\db\Migration;

class m150701_104628_files_and_images extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%files}}', [
            'id' => Schema::TYPE_PK,
            'type' => Schema::TYPE_STRING,
            'source_name' => Schema::TYPE_STRING,
            'name' => Schema::TYPE_STRING,
            'format' => Schema::TYPE_STRING,
            'size' => Schema::TYPE_BIGINT,
            'created_at' => Schema::TYPE_DATETIME . ' NOT NULL'
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%files}}');
    }
}
