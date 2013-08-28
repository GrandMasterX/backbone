<?php

class m130714_080808_add_data_to_mailing_list_tempate_table extends CDbMigration
{
	public function up()
	{
            $this->insert('mailing_list_template',array('title'=>'Шаблон 1','view_file'=>'template1'));
            $this->insert('mailing_list_template',array('title'=>'Шаблон 2','view_file'=>'template2'));
            $this->insert('mailing_list_template',array('title'=>'Шаблон 3','view_file'=>'template3'));
            $this->insert('mailing_list_template',array('title'=>'Шаблон 4','view_file'=>'template4'));
            $this->insert('mailing_list_template',array('title'=>'Шаблон 5','view_file'=>'template5'));
            $this->insert('mailing_list_template',array('title'=>'Шаблон 6','view_file'=>'template6'));
            $this->insert('mailing_list_template',array('title'=>'Шаблон 7','view_file'=>'template7'));
	}

	public function down()
	{
		echo "m130714_080808_add_data_to_mailing_list_tempate_table does not support migration down.\n";
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