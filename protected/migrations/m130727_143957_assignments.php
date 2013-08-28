<?php

class m130727_143957_assignments extends CDbMigration
{
	public function up()
	{
        $this->insert('auth_item_user_assn',array('itemname'=>'superadmin','userid'=>3));

        $this->getDbConnection()->createCommand(
            'INSERT INTO auth_item_user_assn (itemname,userid)
             SELECT * FROM
             (SELECT name FROM auth_item WHERE name=\'client\') AS itemname,
             (SELECT id FROM user WHERE id>10 AND id!=390) AS userid;'
        )->execute();

	}

	public function down()
	{
		echo "m130727_143957_assignments does not support migration down.\n";
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