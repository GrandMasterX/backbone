<?php

class m130130_135932_add_code_filed_to_language extends CDbMigration
{
	public function up()
	{
        $this->addColumn('languages', 'code', 'varchar(10) DEFAULT NULL');
	}

	public function down()
	{
		echo "m130130_135932_add_code_filed_to_language does not support migration down.\n";
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