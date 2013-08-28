<?php

class m130320_191831_vpr_di_dbs_rpli_for_itemSize extends CDbMigration
{
	public function up()
	{

        $this->addColumn('itemsize', 'vpr', ' decimal(10,3) DEFAULT 0 COMMENT \'Высота проймы\'');
        $this->addColumn('itemsize', 'di', ' decimal(10,3) DEFAULT 0 COMMENT \'Длина изделия\'');
        $this->addColumn('itemsize', 'rpli', ' decimal(10,3) DEFAULT 0 COMMENT \'Разлет плечевой изделия\'');        
        
	}

	public function down()
	{
		echo "m130320_191831_vpr_di_dbs_rpli_for_itemSize does not support migration down.\n";
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