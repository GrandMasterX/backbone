<?php

class m130301_063957_formula_type_id extends CDbMigration
{
	public function up()
	{
        $this->addColumn('formula', 'type_id', ' int(10) NOT NULL COMMENT \'Модель изделия, к которой относится формула\'');
	}

	public function down()
	{
		echo "m130301_063957_formula_type_id does not support migration down.\n";
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