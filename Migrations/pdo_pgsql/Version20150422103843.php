<?php

namespace Claroline\CoreBundle\Migrations\pdo_pgsql;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated migration based on mapping information: modify it with caution
 *
 * Generation date: 2015/04/22 10:38:44
 */
class Version20150422103843 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql("
            CREATE TABLE claro_ordered_tool_translation (
                id SERIAL NOT NULL, 
                locale VARCHAR(8) NOT NULL, 
                object_class VARCHAR(255) NOT NULL, 
                field VARCHAR(32) NOT NULL, 
                foreign_key VARCHAR(64) NOT NULL, 
                content TEXT DEFAULT NULL, 
                PRIMARY KEY(id)
            )
        ");
        $this->addSql("
            CREATE INDEX tool_ordered_translation_idx ON claro_ordered_tool_translation (
                locale, object_class, field, foreign_key
            )
        ");
        $this->addSql("
            CREATE TABLE claro_tool_translation (
                id SERIAL NOT NULL, 
                locale VARCHAR(8) NOT NULL, 
                object_class VARCHAR(255) NOT NULL, 
                field VARCHAR(32) NOT NULL, 
                foreign_key VARCHAR(64) NOT NULL, 
                content TEXT DEFAULT NULL, 
                PRIMARY KEY(id)
            )
        ");
        $this->addSql("
            CREATE INDEX tool_translation_idx ON claro_tool_translation (
                locale, object_class, field, foreign_key
            )
        ");
        $this->addSql("
            DROP INDEX ordered_tool_unique_name_by_workspace
        ");
        $this->addSql("
            ALTER TABLE claro_ordered_tool 
            ADD displayedName VARCHAR(255) DEFAULT NULL
        ");
        $this->addSql("
            ALTER TABLE claro_ordered_tool 
            DROP name
        ");
        $this->addSql("
            ALTER TABLE claro_tools RENAME COLUMN display_name TO displayedName
        ");
    }

    public function down(Schema $schema)
    {
        $this->addSql("
            DROP TABLE claro_ordered_tool_translation
        ");
        $this->addSql("
            DROP TABLE claro_tool_translation
        ");
        $this->addSql("
            ALTER TABLE claro_ordered_tool 
            ADD name VARCHAR(255) NOT NULL
        ");
        $this->addSql("
            ALTER TABLE claro_ordered_tool 
            DROP displayedName
        ");
        $this->addSql("
            CREATE UNIQUE INDEX ordered_tool_unique_name_by_workspace ON claro_ordered_tool (workspace_id, name)
        ");
        $this->addSql("
            ALTER TABLE claro_tools RENAME COLUMN displayedname TO display_name
        ");
    }
}