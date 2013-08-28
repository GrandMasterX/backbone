<?php

class m130805_092749_more_client_properties extends CDbMigration
{
	public function up()
	{
        $this->addColumn('client_size', 'vlok', 'decimal(10,3) DEFAULT 0 COMMENT \'Высота локтя\'');
        $this->addColumn('client_size', 'vprch', ' decimal(10,3) DEFAULT 0 COMMENT \'Высота проймы человека\'');
        $this->addColumn('client_size', 'drvnch', ' decimal(10,3) DEFAULT 0 COMMENT \'Длина руки человека внутренняя\'');
	}

	public function down()
	{
		echo "m130805_092749_more_client_properties does not support migration down.\n";
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