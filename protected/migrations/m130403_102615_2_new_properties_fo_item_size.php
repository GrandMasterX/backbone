<?php

class m130403_102615_2_new_properties_fo_item_size extends CDbMigration
{
	public function up()
	{
        $this->addColumn('itemsize', 'iwar', ' decimal(10,2) DEFAULT NULL COMMENT \'Ширина на уровне груди в ратянутом виде при наличии резинки\'');
        $this->addColumn('itemsize', 'iwwr', ' decimal(10,2) DEFAULT NULL COMMENT \'Ширина на уровне талии в ратянутом виде при наличии резинки\'');
	}

	public function down()
	{
		echo "m130403_102615_2_new_properties_fo_item_size does not support migration down.\n";
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