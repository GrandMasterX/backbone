<?php

class m130512_193413_logg_add_info extends CDbMigration
{
	public function up()
	{
        $this->addColumn('log', 'video_id', 'varchar(255)');
        $this->addColumn('log', 'video_title', 'text');
        $this->addColumn('log', 'session_id', 'varchar(7)');
	}

	public function down()
	{
		echo "m130512_193413_logg_add_info does not support migration down.\n";
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