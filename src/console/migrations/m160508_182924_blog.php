<?php

use yii\db\Migration;

class m160508_182924_blog extends Migration
{
    public function up()
    {
        $this->createTable('{{%blog_post_category}}', [
            'id' => $this->primaryKey(),
            'parent_id' => $this->integer(11),
            'title' => $this->string()->notNull(),
            'image_id' => $this->integer(11),
            'slug' => $this->string()->notNull(),
            'sort' => $this->integer()->notNull(),
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime()->notNull()
        ]);

        $this->createTable('{{%blog_post}}', [
            'id' => $this->primaryKey(),
            'author_id' => $this->integer(11),
            'title' => $this->string()->notNull(),
            'category_id' => $this->integer(11),
            'summary' => $this->text(),
            'content' => $this->text(),
            'image_id' => $this->integer(11),
            'slug' => $this->string()->notNull(),
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime()->notNull()
        ]);

        $this->addForeignKey('fk_post_category_parent_id', '{{%blog_post_category}}', 'parent_id', '{{%blog_post_category}}', 'id');
        $this->addForeignKey('fk_post_category_id', '{{%blog_post}}', 'category_id', '{{%blog_post_category}}', 'id');
        $this->addForeignKey('fk_post_author_id', '{{%blog_post}}', 'author_id', '{{%auth_user}}', 'id');
    }

    public function down()
    {
        $this->dropForeignKey('fk_post_category_parent_id', '{{%blog_post_category}}');
        $this->dropForeignKey('fk_post_category_id', '{{%blog_post}}');
        $this->dropForeignKey('fk_post_author_id', '{{%blog_post}}');

        $this->dropTable('{{%blog_post}}');
        $this->dropTable('{{%blog_post_category}}');
    }
}
