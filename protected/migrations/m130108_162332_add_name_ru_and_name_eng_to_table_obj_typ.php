<?php

class m130108_162332_add_name_ru_and_name_eng_to_table_obj_typ extends CDbMigration
{
	public function up()
	{
        $this->addColumn('obj_type', 'title_ru', 'varchar(64) NOT NULL');
        $this->addColumn('obj_type', 'title_en', 'varchar(64) NOT NULL');
	}

	public function down()
	{
		echo "m130108_162332_add_name_ru_and_name_eng_to_table_obj_typ does not support migration down.\n";
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