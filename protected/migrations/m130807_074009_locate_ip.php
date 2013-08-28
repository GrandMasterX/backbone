<?php

class m130807_074009_locate_ip extends CDbMigration
{
	public function up()
	{
        $this->addColumn('log', 'country', 'varchar(20)'); 
        $this->addColumn('log', 'city', 'varchar(20)'); 
	}

	public function down()
	{
		echo "m130807_074009_locate_ip does not support migration down.\n";
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