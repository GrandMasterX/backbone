<?php

class m130802_101229_rent_price_and_brand_for_item extends CDbMigration
{
	public function up()
	{
        $this->addColumn('item','brand','varchar(255) DEFAULT NULL');
        $this->addColumn('item','price_rent','int(10) DEFAULT NULL');
	}

	public function down()
	{
		echo "m130802_101229_rent_price_and_brand_for_item does not support migration down.\n";
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