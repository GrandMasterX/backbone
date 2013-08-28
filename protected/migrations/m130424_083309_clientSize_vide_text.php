<?php

class m130424_083309_clientSize_vide_text extends CDbMigration
{
	public function up()
	{
        $this->addColumn('clientsize', 'video_text', 'text');
	}

	public function down()
	{
		echo "m130424_083309_clientSize_vide_text does not support migration down.\n";
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