<?php

class m130611_082542_parent_id_for_item extends CDbMigration
{
	public function up()
	{
        $this->addColumn('item', 'parent_id', 'int(11) DEFAULT NULL');
	}

	public function down()
	{
		echo "m130611_082542_parent_id_for_item does not support migration down.\n";
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