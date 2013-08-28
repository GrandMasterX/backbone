<?php

class m130805_084351_vpl_for_client_height extends CDbMigration
{
	public function up()
	{
        $this->addColumn('client_size', 'vpl', ' decimal(10,3) DEFAULT 0 COMMENT \'Высота плечевой точки\'');
	}

	public function down()
	{
		echo "m130805_084351_vpl_for_client_height does not support migration down.\n";
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