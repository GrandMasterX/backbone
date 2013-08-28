<?php

class m130325_142821_res_label_for_formula extends CDbMigration
{
	public function up()
	{
        $this->addColumn('formula', 'type', ' tinyint(1) DEFAULT 1 COMMENT \'Тип формулы, 1=нормал, 2=оценочная\'');
	}

	public function down()
	{
		echo "m130325_142821_res_label_for_formula does not support migration down.\n";
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