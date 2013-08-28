<?php

class m130730_192814_update_user_language_to_ru extends CDbMigration
{
	public function up()
	{
        $this->update('user',array('language'=>'ru'));
	}

	public function down()
	{
		echo "m130730_192814_update_user_language_to_ru does not support migration down.\n";
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