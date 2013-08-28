<?php

class m130404_143917_range_for_res_formula_title extends CDbMigration
{
	public function up()
	{
        $this->addColumn('resformulatitle', 'range', ' varchar(10) DEFAULT NULL COMMENT \'Название диапазона, значение которого будет использоваться в расчетах\'');
	}

	public function down()
	{
		echo "m130404_143917_range_for_res_formula_title does not support migration down.\n";
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