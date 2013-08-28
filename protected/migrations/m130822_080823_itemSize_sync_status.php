<?php

class m130822_080823_itemSize_sync_status extends CDbMigration
{
	public function up()
	{
        $this->addColumn('itemsize','sync_status','tinyint(1) DEFAULT NULL');
        $this->addColumn('itemsize_source','sync_status','tinyint(1) DEFAULT NULL');
	}

	public function down()
	{
		echo "m130822_080823_itemSize_sync_status does not support migration down.\n";
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