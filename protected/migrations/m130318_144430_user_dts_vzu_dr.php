<?php

class m130318_144430_user_dts_vzu_dr extends CDbMigration
{
	public function up()
	{
        $this->addColumn('client_size', 'vzu', ' decimal(10,3) DEFAULT 0 COMMENT \'ВЗУ\'');
        $this->addColumn('client_size', 'dts', ' decimal(10,3) DEFAULT 0 COMMENT \'ДТС\'');
        $this->addColumn('client_size', 'dr', ' decimal(10,3) DEFAULT 0 COMMENT \'Длина руки\'');
	}

	public function down()
	{
		echo "m130318_144430_user_dts_vzu_dr does not support migration down.\n";
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