<?php

class m130712_071906_promo_code extends CDbMigration
{
	public function up()
	{
        $this->addColumn('user', 'promo_code', 'int(4) DEFAULT NULL');
	}

	public function down()
	{
		echo "m130712_071906_promo_code does not support migration down.\n";
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