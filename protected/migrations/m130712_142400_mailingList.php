<?php

class m130712_142400_mailingList extends CDbMigration
{
	public function up()
	{
         $this->addColumn('mailing_list', 'sent_count', 'smallint(3) DEFAULT \'0\'');
	}

	public function down()
	{
		echo "m130712_142400_mailingList does not support migration down.\n";
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