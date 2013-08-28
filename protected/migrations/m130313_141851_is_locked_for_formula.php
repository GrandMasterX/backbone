<?php

class m130313_141851_is_locked_for_formula extends CDbMigration
{
	public function up()
	{
        $this->addColumn('formula', 'is_locked', 'tinyint(1) unsigned NOT NULL DEFAULT "0"');
	}

	public function down()
	{
		echo "m130313_141851_is_locked_for_formula does not support migration down.\n";
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