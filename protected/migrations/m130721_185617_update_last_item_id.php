<?php

class m130721_185617_update_last_item_id extends CDbMigration
{
	public function up()
	{
            $this->getDbConnection()->createCommand(
            'UPDATE user SET last_item_id=(SELECT item_id FROM log WHERE client_id=user.id ORDER BY create_time DESC LIMIT 1);'
        )->execute();         
	}

	public function down()
	{
		echo "m130721_185617_update_last_item_id does not support migration down.\n";
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