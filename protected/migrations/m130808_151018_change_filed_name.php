<?php

class m130808_151018_change_filed_name extends CDbMigration
{
	public function up()
	{
        $this->renameColumn('user','s_gender','gender');
        $this->renameColumn('user','s_mphoto','photo');
        $this->addColumn('user','birthday','varchar(12) DEFAULT NULL');
	}

	public function down()
	{
		echo "m130808_151018_change_filed_name does not support migration down.\n";
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