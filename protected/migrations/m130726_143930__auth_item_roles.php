<?php

class m130726_143930__auth_item_roles extends CDbMigration
{
	public function up()
	{
        $this->insert('authitem',array('name'=>'superadmin','type'=>'1','description'=>'Супер администратор'));
        $this->insert('authitem',array('name'=>'admin','type'=>'2','description'=>'Администратор'));
        $this->insert('authitem',array('name'=>'consultant','type'=>'3','description'=>'Консультант'));
	}

	public function down()
	{
		echo "m130726_143930__auth_item_roles does not support migration down.\n";
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