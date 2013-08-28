<?php

class m130522_125017_service_title_for_itemsize extends CDbMigration
{
	public function up()
	{
        $this->addColumn('clientsize', 'service_title', 'varchar(10)');
        $this->update('clientsize', array('service_title'=>'Р'),'id=:id',array(':id'=>7));
        $this->update('clientsize', array('service_title'=>'ОГ'),'id=:id',array(':id'=>8));
        $this->update('clientsize', array('service_title'=>'ОТ'),'id=:id',array(':id'=>9));
        $this->update('clientsize', array('service_title'=>'ОБ2'),'id=:id',array(':id'=>10));
        $this->update('clientsize', array('service_title'=>'ДРЗ'),'id=:id',array(':id'=>11));
        $this->update('clientsize', array('service_title'=>'ОР'),'id=:id',array(':id'=>12));
        $this->update('clientsize', array('service_title'=>'ШГ'),'id=:id',array(':id'=>13));
        $this->update('clientsize', array('service_title'=>'РПЛ'),'id=:id',array(':id'=>14));
	}

	public function down()
	{
		echo "m130522_125017_service_title_for_itemsize does not support migration down.\n";
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