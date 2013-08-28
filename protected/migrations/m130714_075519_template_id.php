<?php

class m130714_075519_template_id extends CDbMigration
{
	public function up()
	{
        $this->addColumn('mailing_list','template_id','int(10) NOT NULL');
        $this->dropColumn('mailing_list','template');
	}

	public function down()
	{
		echo "m130714_075519_template_id does not support migration down.\n";
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