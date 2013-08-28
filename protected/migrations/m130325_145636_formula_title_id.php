<?php

class m130325_145636_formula_title_id extends CDbMigration
{
	public function up()
	{
        $this->addColumn('formula', 'title_id', ' int(12) DEFAULT NULL COMMENT \'Id наименования для оценочных формул\'');
	}

	public function down()
	{
		echo "m130325_145636_formula_title_id does not support migration down.\n";
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