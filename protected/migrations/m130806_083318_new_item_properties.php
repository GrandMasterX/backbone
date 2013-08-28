<?php

class m130806_083318_new_item_properties extends CDbMigration
{
	public function up()
	{
        $this->addColumn('item','stretchp','decimal(10,2) DEFAULT 0 COMMENT \'Максимальное растяжение подкладки\'');
        $this->addColumn('item','bretel','tinyint(1) DEFAULT 0 COMMENT \'Наличие бретелей: есть или нет\'');
        $this->addColumn('item','fabric_id','int(3) DEFAULT 0 COMMENT \'Тип ткани:  костюмная, трикотаж, блузочная, кобинированная\'');

        $this->addColumn('item','fabric_iwa_id','int(3) DEFAULT 0 COMMENT \'Тип ткани по ШУГ:  костюмная, трикотаж, блузочная\'');
        $this->addColumn('item','fabric_iwa_stretch','decimal(10,2) DEFAULT 0 COMMENT \'Макс.нат ткани по ШУГ\'');

        $this->addColumn('item','fabric_iww_id','int(3) DEFAULT 0 COMMENT \'Тип ткани по ШУТ:  костюмная, трикотаж, блузочная\'');
        $this->addColumn('item','fabric_iww_stretch','decimal(10,2) DEFAULT 0 COMMENT \'Макс.нат ткани по ШУТ\'');

        $this->addColumn('item','fabric_iwt_id','int(3) DEFAULT 0 COMMENT \'Тип ткани по ШУБ:  костюмная, трикотаж, блузочная\'');
        $this->addColumn('item','fabric_iwt_stretch','decimal(10,2) DEFAULT 0 COMMENT \'Макс.нат ткани по ШУБ\'');
	}

	public function down()
	{
		echo "m130806_083318_new_item_properties does not support migration down.\n";
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