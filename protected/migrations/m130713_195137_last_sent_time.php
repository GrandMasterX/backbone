<?php

class m130713_195137_last_sent_time extends CDbMigration
{
	public function up()
	{
        $this->addColumn('mailing_list', 'last_sent_time', 'datetime DEFAULT NULL');
	}

	public function down()
	{
		echo "m130713_195137_last_sent_time does not support migration down.\n";
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