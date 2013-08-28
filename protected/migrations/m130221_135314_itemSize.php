<?php

class m130221_135314_itemSize extends CDbMigration
{
	public function up()
	{
        $this->addColumn('itemsize', 'bw', ' decimal(10,2) DEFAULT NULL COMMENT \'Ширина спинки (ШС)\'');
	}

	public function down()
	{
		echo "m130221_135314_itemSize does not support migration down.\n";
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