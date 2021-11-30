<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211129135257 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD profile_id INT DEFAULT NULL, ADD prof_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649CCFA12B8 FOREIGN KEY (profile_id) REFERENCES etudiant (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6496E851E1D FOREIGN KEY (prof_id_id) REFERENCES professeur (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649CCFA12B8 ON user (profile_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D6496E851E1D ON user (prof_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649CCFA12B8');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6496E851E1D');
        $this->addSql('DROP INDEX UNIQ_8D93D649CCFA12B8 ON user');
        $this->addSql('DROP INDEX UNIQ_8D93D6496E851E1D ON user');
        $this->addSql('ALTER TABLE user DROP profile_id, DROP prof_id_id');
    }
}
