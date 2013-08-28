<?php

class m130725_102654_update_time_for_mailing_list_stat extends CDbMigration
{
	public function up()
	{
        $this->addColumn('mailing_list_stat', 'update_time', 'date DEFAULT NULL');
	}

	public function down()
	{
		echo "m130725_102654_update_time_for_mailing_list_stat does not support migration down.\n";
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