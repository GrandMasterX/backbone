<?php

class m130730_123202_user_social_columns extends CDbMigration
{
	public function up()
	{
            $this->addColumn('user','s_id','tinyint(10) NOT NULL');
            $this->addColumn('user','s_url','varchar(255) NOT NULL');
            $this->addColumn('user','s_gender','varchar(255) NOT NULL');
            $this->addColumn('user','s_name','varchar(255) NOT NULL');
            $this->addColumn('user','social','varchar(255) NOT NULL');
            $this->addColumn('user','timezone','varchar(255) NOT NULL');
            $this->addColumn('user','city','tinyint(10) NOT NULL');
            $this->addColumn('user','country','tinyint(10) NOT NULL');
            $this->addColumn('user','s_mphoto','varchar(10) NOT NULL');
            //$this->addColumn('user','template_id','int(10) NOT NULL');
	}

	public function down()
	{
		echo "m130730_123202_user_social_columns does not support migration down.\n";
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