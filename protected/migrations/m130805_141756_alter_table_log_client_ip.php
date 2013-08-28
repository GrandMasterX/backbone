<?php

class m130805_141756_alter_table_log_client_ip extends CDbMigration
{
	public function up()
	{
        $this->alterColumn('log', 'client_ip', 'varchar(30)');
	}

	public function down()
	{
		echo "m130805_141756_alter_table_log_client_ip does not support migration down.\n";
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