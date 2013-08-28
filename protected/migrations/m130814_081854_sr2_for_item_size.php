<?php

class m130814_081854_sr2_for_item_size extends CDbMigration
{
	public function up()
	{
        $this->addColumn('itemsize','iws2','decimal(10,2) DEFAULT 0 COMMENT \'Ширина рукава растянутая (ШР2)\'');
	}

	public function down()
	{
		echo "m130814_081854_sr2_for_item_size does not support migration down.\n";
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