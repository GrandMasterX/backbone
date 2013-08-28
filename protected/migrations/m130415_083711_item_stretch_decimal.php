<?php

class m130415_083711_item_stretch_decimal extends CDbMigration
{
	public function up()
	{
        $this->alterColumn('item', 'stretch', 'decimal(10,2)');        
	}

	public function down()
	{
		echo "m130415_083711_item_stretch_decimal does not support migration down.\n";
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