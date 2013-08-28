<?php

class m130725_103810_change_date_to_datetime_in_mailing_list_stat extends CDbMigration
{
	public function up()
	{
        $this->alterColumn('mailing_list_stat','create_time','datetime');
        $this->alterColumn('mailing_list_stat','update_time','datetime');
	}

	public function down()
	{
		echo "m130725_103810_change_date_to_datetime_in_mailing_list_stat does not support migration down.\n";
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