<?php

class m130405_100058_varchar_to_text_for_itemTypeTranslation extends CDbMigration
{
	public function up()
	{
        $this->alterColumn('itemtype_translation','title', 'text');
	}

	public function down()
	{
		echo "m130405_100058_varchar_to_text_for_itemTypeTranslation does not support migration down.\n";
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