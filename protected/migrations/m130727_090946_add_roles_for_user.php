<?php

class m130727_090946_add_roles_for_user extends CDbMigration
{
	public function up()
	{
        $this->insert('auth_item',array('name'=>'view_admin','type'=>3,'description'=>'Просмотреть администраторов'));
        $this->insert('auth_item',array('name'=>'create_admin','type'=>3,'description'=>'Создать администратора'));
        $this->insert('auth_item',array('name'=>'update_admin','type'=>3,'description'=>'Редактировать администратора'));
        $this->insert('auth_item',array('name'=>'mark_as_deleted_admin','type'=>3,'description'=>'Удалить администратора (остается в БД)'));
        $this->insert('auth_item',array('name'=>'block_admin','type'=>3,'description'=>'Заблокировать администратора'));
        $this->insert('auth_item',array('name'=>'generate_password_admin','type'=>3,'description'=>'Генерировать пароль'));
        $this->insert('auth_item',array('name'=>'change_password_admin','type'=>3,'description'=>'Сменить пароль'));
        $this->insert('auth_item',array('name'=>'email_password_admin','type'=>3,'description'=>'Отправить пароль на email'));
        $this->insert('auth_item',array('name'=>'guest','type'=>1,'description'=>'Гость'));
	}

	public function down()
	{
		echo "m130727_090946_add_roles_for_user does not support migration down.\n";
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