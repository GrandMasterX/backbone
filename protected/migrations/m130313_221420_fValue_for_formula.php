<?php

class m130313_221420_fValue_for_formula extends CDbMigration
{
	public function up()
	{
        $this->addColumn('formula', 'fvalue', ' varchar(50) NOT NULL COMMENT \'Контейнер со значением оценочной формулы\'');
	}

	public function down()
	{
		echo "m130313_221420_fValue_for_formula does not support migration down.\n";
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