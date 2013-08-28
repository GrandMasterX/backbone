<?php

class m130721_183725_last_item_id_for_user extends CDbMigration
{
	public function up()
	{
        $this->addColumn('user', 'last_item_id', 'int(12) unsigned DEFAULT NULL');
	}

	public function down()
	{
		echo "m130721_183725_last_item_id_for_user does not support migration down.\n";
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