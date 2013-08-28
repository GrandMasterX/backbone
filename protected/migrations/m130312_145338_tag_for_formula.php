<?php

class m130312_145338_tag_for_formula extends CDbMigration
{
	public function up()
	{
        $this->addColumn('formula', 'tag', ' varchar(50) NOT NULL COMMENT \'Краткое наименование формулы\'');
	}

	public function down()
	{
		echo "m130312_145338_tag_for_formula does not support migration down.\n";
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