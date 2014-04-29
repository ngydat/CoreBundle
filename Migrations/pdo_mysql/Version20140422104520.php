<?php

namespace Claroline\CoreBundle\Migrations\pdo_mysql;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated migration based on mapping information: modify it with caution
 *
 * Generation date: 2014/04/22 10:45:24
 */
class Version20140422104520 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql("
            CREATE TABLE claro_user_role_creation (
                id INT AUTO_INCREMENT NOT NULL, 
                user_id INT NOT NULL, 
                creation_date DATETIME NOT NULL, 
                userRole_id INT NOT NULL, 
                INDEX IDX_709FE2E85DFE78E (userRole_id), 
                INDEX IDX_709FE2EA76ED395 (user_id), 
                PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB
        ");
        $this->addSql("
            ALTER TABLE claro_user_role_creation 
            ADD CONSTRAINT FK_709FE2E85DFE78E FOREIGN KEY (userRole_id) 
            REFERENCES claro_role (id)
        ");
        $this->addSql("
            ALTER TABLE claro_user_role_creation 
            ADD CONSTRAINT FK_709FE2EA76ED395 FOREIGN KEY (user_id) 
            REFERENCES claro_user (id)
        ");
        $this->addSql("
            ALTER TABLE claro_role 
            DROP creation_date
        ");
    }

    public function down(Schema $schema)
    {
        $this->addSql("
            DROP TABLE claro_user_role_creation
        ");
        $this->addSql("
            ALTER TABLE claro_role 
            ADD creation_date DATETIME NOT NULL
        ");
    }
}