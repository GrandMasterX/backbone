<?php

class m130719_091454_user_count_for_mailing_list_table extends CDbMigration
{
	public function up()
	{
        $this->addColumn('mailing_list','user_count','int(12) unsigned DEFAULT \'0\' NOT NULL');
	}

	public function down()
	{
		echo "m130719_091454_user_count_for_mailing_list_table does not support migration down.\n";
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