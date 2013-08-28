<?php

class m130121_094846__hash_field_for_user_table extends CDbMigration
{
	public function up()
	{
        $this->addColumn('user', 'hash', 'varchar(255) NOT NULL');
	}

	public function down()
	{
		echo "m130121_094846__hash_field_for_user_table does not support migration down.\n";
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