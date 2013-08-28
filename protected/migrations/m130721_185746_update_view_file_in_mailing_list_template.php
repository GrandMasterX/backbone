<?php

class m130721_185746_update_view_file_in_mailing_list_template extends CDbMigration
{
	public function up()
	{
        $this->truncateTable('mailing_list_template');
        $this->insert('mailing_list_template',array('title'=>'Напоминание','view_file'=>'template1'));
	}

	public function down()
	{
		echo "m130721_185746_update_view_file_in_mailing_list_template does not support migration down.\n";
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