<?php

class m130106_220125_add_created_by_id_to_obj_category_table extends CDbMigration
{
	public function up()
	{
        
        $this->addColumn('obj_category', 'created_by_id', ' int(10) unsigned NOT NULL');
        $this->addColumn('obj_category', 'updated_by_id', ' int(10) unsigned DEFAULT NULL');
	}

	public function down()
	{
		echo "m130106_220125_add_created_by_id_to_obj_category_table does not support migration down.\n";
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