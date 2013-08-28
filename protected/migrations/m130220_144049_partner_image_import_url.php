<?php

class m130220_144049_partner_image_import_url extends CDbMigration
{
	public function up()
	{
        $this->addColumn('user', 'image_import_url', 'text');
	}

	public function down()
	{
		echo "m130220_144049_partner_image_import_url does not support migration down.\n";
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