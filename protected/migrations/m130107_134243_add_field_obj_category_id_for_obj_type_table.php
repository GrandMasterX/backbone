<?php

class m130107_134243_add_field_obj_category_id_for_obj_type_table extends CDbMigration
{
	public function up()
	{
        $this->addColumn('obj_type', 'obj_category_id', 'int(10) unsigned DEFAULT NULL');
	}

	public function down()
	{
		echo "m130107_134243_add_field_obj_category_id_for_obj_type_table does not support migration down.\n";
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