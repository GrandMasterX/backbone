<?php

class m130106_214710_add_is_blocked_field_to_obj_category_table extends CDbMigration
{
	public function up()
	{
        $this->addColumn('obj_category', 'is_blocked', 'tinyint(1) unsigned NOT NULL DEFAULT "0"');
	}

	public function down()
	{
		echo "m130106_214710_add_is_blocked_field_to_obj_category_table does not support migration down.\n";
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