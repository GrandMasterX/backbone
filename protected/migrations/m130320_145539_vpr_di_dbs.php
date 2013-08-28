<?php

class m130320_145539_vpr_di_dbs extends CDbMigration
{
	public function up()
	{
        $this->addColumn('item', 'vpr', ' decimal(10,3) DEFAULT 0 COMMENT \'Высота проймы\'');
        $this->addColumn('item', 'di', ' decimal(10,3) DEFAULT 0 COMMENT \'Длина изделия\'');
        $this->addColumn('item', 'rpli', ' decimal(10,3) DEFAULT 0 COMMENT \'Разлет плечевой изделия\'');
	}

	public function down()
	{
		echo "m130320_145539_vpr_di_dbs does not support migration down.\n";
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