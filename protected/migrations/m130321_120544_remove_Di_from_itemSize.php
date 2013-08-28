<?php

class m130321_120544_remove_Di_from_itemSize extends CDbMigration
{
	public function up()
	{
        $this->dropColumn('itemsize', 'di');
	}

	public function down()
	{
		echo "m130321_120544_remove_Di_from_itemSize does not support migration down.\n";
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