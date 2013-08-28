<?php

class m130327_081825_parent_for_formula_tbl extends CDbMigration
{
	public function up()
	{
        $this->addColumn('formula', 'parent', ' int(12) DEFAULT NULL COMMENT \'Id родителя\'');
	}

	public function down()
	{
		echo "m130327_081825_parent_for_formula_tbl does not support migration down.\n";
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