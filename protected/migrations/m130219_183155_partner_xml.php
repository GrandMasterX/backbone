<?php

class m130219_183155_partner_xml extends CDbMigration
{
	public function up()
	{
        $this->addColumn('user', 'xml_url', 'varchar(255) DEFAULT NULL');
	}

	public function down()
	{
		echo "m130219_183155_partner_xml does not support migration down.\n";
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