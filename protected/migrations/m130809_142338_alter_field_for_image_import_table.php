<?php

class m130809_142338_alter_field_for_image_import_table extends CDbMigration
{
	public function up()
	{
        $this->addColumn('item_image_import', 'dif_url','text');
	}

	public function down()
	{
		echo "m130809_142338_alter_field_for_image_import_table does not support migration down.\n";
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