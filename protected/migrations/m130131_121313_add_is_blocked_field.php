<?php

class m130131_121313_add_is_blocked_field extends CDbMigration
{
	public function up()
	{
        $this->addColumn('languages', 'is_locked', 'tinyint(1) unsigned NOT NULL DEFAULT "0"');
        $this->addColumn('languages', 'is_blocked', 'tinyint(1) unsigned NOT NULL DEFAULT "0"');
        $this->addColumn('languages', 'created_by_id', ' int(10) unsigned NOT NULL');
        $this->addColumn('languages', 'updated_by_id', ' int(10) unsigned DEFAULT NULL');        
	}

	public function down()
	{
		echo "m130131_121313_add_is_blocked_field does not support migration down.\n";
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