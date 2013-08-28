<?php

class m130226_091235_user_vsht_vk extends CDbMigration
{
	public function up()
	{
        $this->addColumn('client_size', 'vst', ' decimal(10,3) DEFAULT 0 COMMENT \'Высота шейной точки\'');
        $this->addColumn('client_size', 'vk', ' decimal(10,3) DEFAULT 0 COMMENT \'Высота колена\'');
	}

	public function down()
	{
		echo "m130226_091235_user_vsht_vk does not support migration down.\n";
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