<?php

class m130721_191915_mailing_list_update extends CDbMigration
{
	public function up()
	{
        $this->update('mailing_list',array('template_id'=>'1'));
	}

	public function down()
	{
		echo "m130721_191915_mailing_list_update does not support migration down.\n";
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