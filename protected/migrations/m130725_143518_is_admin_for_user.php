<?php

class m130725_143518_is_admin_for_user extends CDbMigration
{
	public function up()
	{
            $this->addColumn('user','is_admin','tinyint(1) DEFAULT NULL');
	}

	public function down()
	{
		echo "m130725_143518_is_admin_for_user does not support migration down.\n";
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