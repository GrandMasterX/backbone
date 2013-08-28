<?php

class m130729_152917_subject_for_mailing_list extends CDbMigration
{
	public function up()
	{
        $this->addColumn('mailing_list','subject','varchar(255) DEFAULT NULL');
	}

	public function down()
	{
		echo "m130729_152917_subject_for_mailing_list does not support migration down.\n";
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