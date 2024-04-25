<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240425102214 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create employees tables.';
    }

    use TheCodingMachine\FluidSchema\TdbmFluidSchema;

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $db = new TdbmFluidSchema($schema);

        $db->table('employees')
            ->column('id')->guid()->primaryKey()->comment('@UUID')
            ->column('full_name')->string(255)->Null()->default(null)
            ->column('address')->string(255)->Null()->default(null)
            ->column('phone')->string(255)->Null()->unique()
            ->column('birth_day')->string(255)->null()->default(null);

    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        throw new RuntimeException('Never rollback a migration!');


    }
}
