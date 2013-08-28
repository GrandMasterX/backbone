<?php

class m130318_111721_alter_title_for_item_type extends CDbMigration
{
	public function up()
	{
        $this->alterColumn('item_type', 'title', ' text DEFAULT NULL COMMENT \'Наименование\'');
	}

	public function down()
	{
		echo "m130318_111721_alter_title_for_item_type does not support migration down.\n";
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