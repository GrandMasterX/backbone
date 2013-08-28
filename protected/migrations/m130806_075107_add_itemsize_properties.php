<?php

class m130806_075107_add_itemsize_properties extends CDbMigration
{
	public function up()
	{
        $this->addColumn('itemsize','iltwo','decimal(10,2) DEFAULT 0 COMMENT \'Длина изделия 2 (ДИ2)\'');
        $this->addColumn('itemsize','iwsstwo','decimal(10,2) DEFAULT 0 COMMENT \'Длина бокового шва 2 (Дбш2)\'');
        $this->addColumn('itemsize','vsl','decimal(10,2) DEFAULT 0 COMMENT \'Высота шлейфа\'');
        $this->addColumn('itemsize','sup','decimal(10,2) DEFAULT 0 COMMENT \'Ширина изделя на уровне подреза (ШУП)\'');
        $this->addColumn('itemsize','iwap','decimal(10,2) DEFAULT 0 COMMENT \'Ширина подкладки на уровне глубины проймы (ШУГп) -Размер чашечки\'');
        $this->addColumn('itemsize','iwwp','decimal(10,2) DEFAULT 0 COMMENT \'Ширина подкладки на уровне талии (ШУТп) -Размер чашечки\'');
        $this->addColumn('itemsize','iwtp','decimal(10,2) DEFAULT 0 COMMENT \'Ширина подкладки на уровне бедерн (ШУБп) -Размер чашечки\'');
	}

	public function down()
	{
		echo "m130806_075107_add_itemsize_properties does not support migration down.\n";
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