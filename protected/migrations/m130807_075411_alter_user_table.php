<?php

class m130807_075411_alter_user_table extends CDbMigration
{
	public function up()
	{
            $this->addColumn('user','completed','int(1) DEFAULT 0 COMMENT \'Заполнены ли основные поля пользователя\'');
	}

	public function down()
	{
		echo "m130807_075411_alter_user_table does not support migration down.\n";
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