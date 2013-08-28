<?php

class m130415_084557_clientSize_video_url extends CDbMigration
{
	public function up()
	{
        $this->addColumn('clientsize', 'video_url', 'text');
	}

	public function down()
	{
		echo "m130415_084557_itemSize_video_url does not support migration down.\n";
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