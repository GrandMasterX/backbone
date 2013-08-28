<?php

class m130809_070611_strech_based_on_combined_fabric_type extends CDbMigration
{
	public function up()
	{
        $this->addColumn('item','fabric_type_iwa','int(10) unsigned DEFAULT NULL COMMENT \'Тип ткани по ШУГ\'');
        $this->addColumn('item','fabric_type_iwa_stretch','decimal(10,2)DEFAULT NULL COMMENT \'Макс.нат ткани по ШУГ\'');

        $this->addColumn('item','fabric_type_iww','int(10) unsigned DEFAULT NULL COMMENT \'Тип ткани по ШУТ\'');
        $this->addColumn('item','fabric_type_iww_stretch','decimal(10,2)DEFAULT NULL COMMENT \'Макс.нат ткани по ШУТ\'');

        $this->addColumn('item','fabric_type_iwt','int(10) unsigned DEFAULT NULL COMMENT \'Тип ткани по ШУБ\'');
        $this->addColumn('item','fabric_type_iwt_stretch','decimal(10,2)DEFAULT NULL COMMENT \'Макс.нат ткани по ШУБ\'');
	}

	public function down()
	{
		echo "m130809_070611_strech_based_on_combined_fabric_type does not support migration down.\n";
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