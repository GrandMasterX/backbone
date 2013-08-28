<?php

class m130807_122841_add_mailing_template extends CDbMigration
{
	public function up()
	{
        $this->insert('mailing_list_template',array('title'=>'Напоминание 2','view_file'=>'template2'));
	}

	public function down()
	{
		echo "m130807_122841_add_mailing_template does not support migration down.\n";
		return false;
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}