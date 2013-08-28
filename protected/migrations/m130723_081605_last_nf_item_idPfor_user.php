<?php

class m130723_081605_last_nf_item_idPfor_user extends CDbMigration
{
	public function up()
	{
        $this->addColumn('user', 'last_nf_item_id', 'int(12) unsigned DEFAULT NULL');
	}

	public function down()
	{
		echo "m130723_081605_last_nf_item_idPfor_user does not support migration down.\n";
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