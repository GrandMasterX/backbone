<?php

class m130716_140043_shop_id_for_user extends CDbMigration
{
	public function up()
	{
        $this->addColumn('user','shop_id','int(10) NOT NULL');
	}

	public function down()
	{
		echo "m130716_140043_shop_id_for_user does not support migration down.\n";
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