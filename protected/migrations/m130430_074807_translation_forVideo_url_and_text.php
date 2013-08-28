<?php

class m130430_074807_translation_forVideo_url_and_text extends CDbMigration
{
	public function up()
	{
        $this->addColumn('clientsize_translation', 'video_url', 'text');
        $this->addColumn('clientsize_translation', 'video_text', 'text');
	}

	public function down()
	{
		echo "m130430_074807_translation_forVideo_url_and_text does not support migration down.\n";
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