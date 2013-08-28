<?php

class m130823_133742_create_workstage_idx extends CDbMigration
{
	public function up()
	{
        $this->createIndex( 'workstage', 'syslog', 'workstage');
	}

	public function down()
	{
		echo "m130823_133742_create_workstage_idx does not support migration down.\n";
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