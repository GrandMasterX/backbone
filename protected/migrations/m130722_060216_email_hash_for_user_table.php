<?php

class m130722_060216_email_hash_for_user_table extends CDbMigration
{
	public function up()
	{
        $this->addColumn('user', 'email_hash', 'varchar(12) DEFAULT NULL COMMENT \'hash для авто логина при переходе по ссылкам из email рассылок\'');
	}

	public function down()
	{
		echo "m130722_060216_email_hash_for_user_table does not support migration down.\n";
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