<?php

class m130124_080702_add_created_by_id_and_updated_by_if_foruser_table extends CDbMigration
{
	public function up()
	{
        $this->addColumn('user', 'created_by_id', 'int(10) unsigned DEFAULT NULL');
        $this->addColumn('user', 'updated_by_id', 'int(10) unsigned DEFAULT NULL');
	}

	public function down()
	{
		echo "m130124_080702_add_created_by_id_and_updated_by_if_foruser_table does not support migration down.\n";
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