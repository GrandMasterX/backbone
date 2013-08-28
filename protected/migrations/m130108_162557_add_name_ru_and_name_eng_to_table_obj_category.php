<?php

class m130108_162557_add_name_ru_and_name_eng_to_table_obj_category extends CDbMigration
{
	public function up()
	{
        $this->addColumn('obj_category', 'title_ru', 'varchar(64) NOT NULL');
        $this->addColumn('obj_category', 'title_en', 'varchar(64) NOT NULL');        
	}

	public function down()
	{
		echo "m130108_162557_add_name_ru_and_name_eng_to_table_obj_category does not support migration down.\n";
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