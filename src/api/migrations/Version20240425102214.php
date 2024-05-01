<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use RuntimeException;
use TheCodingMachine\FluidSchema\TdbmFluidSchema;


/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240425102214 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create employees tables.';
    }


    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $db = new TdbmFluidSchema($schema);

        $db->table('employees')
            ->column('id')->guid()->primaryKey()->comment('@UUID')
            ->column('full_name')->string(255)->notNull()
            ->column('address')->string(255)->Null()->default(null)
            ->column('phone')->string(255)->notNull()
            ->column('email')->string(255)->notNull()->unique();

    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        throw new RuntimeException('Never rollback a migration!');


    }
}
