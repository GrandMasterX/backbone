<?php

class m130219_185146_import_date_and_xml_file_date extends CDbMigration
{
	public function up()
	{
        $this->addColumn('user', 'last_import_date', 'datetime DEFAULT NULL');
        $this->addColumn('user', 'xml_import_file_date', 'datetime DEFAULT NULL');
	}

	public function down()
	{
		echo "m130219_185146_import_date_and_xml_file_date does not support migration down.\n";
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