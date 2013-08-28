<?php

class m130514_081230_logg_client_ip extends CDbMigration
{
	public function up()
	{
        $this->addColumn('log', 'client_ip', 'int UNSIGNED DEFAULT NULL');
	}

	public function down()
	{
		echo "m130514_081230_logg_client_ip does not support migration down.\n";
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