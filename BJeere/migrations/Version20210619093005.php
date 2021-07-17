<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210619093005 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commandes DROP FOREIGN KEY FK_35D4282C7F2DEE08');
        $this->addSql('DROP INDEX UNIQ_35D4282C7F2DEE08 ON commandes');
        $this->addSql('ALTER TABLE commandes DROP facture_id');
        $this->addSql('ALTER TABLE factures DROP FOREIGN KEY FK_647590B82EA2E54');
        $this->addSql('DROP INDEX UNIQ_647590B82EA2E54 ON factures');
        $this->addSql('ALTER TABLE factures DROP commande_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commandes ADD facture_id INT NOT NULL');
        $this->addSql('ALTER TABLE commandes ADD CONSTRAINT FK_35D4282C7F2DEE08 FOREIGN KEY (facture_id) REFERENCES factures (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_35D4282C7F2DEE08 ON commandes (facture_id)');
        $this->addSql('ALTER TABLE factures ADD commande_id INT NOT NULL');
        $this->addSql('ALTER TABLE factures ADD CONSTRAINT FK_647590B82EA2E54 FOREIGN KEY (commande_id) REFERENCES commandes (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_647590B82EA2E54 ON factures (commande_id)');
    }
}
