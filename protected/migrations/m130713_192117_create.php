<?php

class m130713_192117_create extends CDbMigration
{
	public function up()
	{
        $this->addColumn('mailing_list', 'create_time', 'datetime DEFAULT NULL');
        $this->addColumn('mailing_list', 'update_time', 'datetime DEFAULT NULL');
	}

	public function down()
	{
		echo "m130713_192117_create does not support migration down.\n";
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