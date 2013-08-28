<?php

class m130220_154935_calculatePercetage extends CDbMigration
{
	public function up()
	{
        $this->addColumn('item', 'stretch_percentage', 'decimal DEFAULT NULL');
	}

	public function down()
	{
		echo "m130220_154935_calculatePercetage does not support migration down.\n";
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