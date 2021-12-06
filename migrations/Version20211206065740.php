<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211206065740 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE subscriptions ADD user_id INT NOT NULL, ADD service_id INT NOT NULL');
        $this->addSql('ALTER TABLE subscriptions ADD CONSTRAINT FK_4778A01A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE subscriptions ADD CONSTRAINT FK_4778A01ED5CA9E6 FOREIGN KEY (service_id) REFERENCES services (id)');
        $this->addSql('CREATE INDEX IDX_4778A01A76ED395 ON subscriptions (user_id)');
        $this->addSql('CREATE INDEX IDX_4778A01ED5CA9E6 ON subscriptions (service_id)');
        $this->addSql('ALTER TABLE transactions ADD balance_id INT DEFAULT NULL, ADD service_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE transactions ADD CONSTRAINT FK_EAA81A4CAE91A3DD FOREIGN KEY (balance_id) REFERENCES balances (id)');
        $this->addSql('ALTER TABLE transactions ADD CONSTRAINT FK_EAA81A4CED5CA9E6 FOREIGN KEY (service_id) REFERENCES services (id)');
        $this->addSql('CREATE INDEX IDX_EAA81A4CAE91A3DD ON transactions (balance_id)');
        $this->addSql('CREATE INDEX IDX_EAA81A4CED5CA9E6 ON transactions (service_id)');
        $this->addSql('ALTER TABLE users ADD balance_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E9AE91A3DD FOREIGN KEY (balance_id) REFERENCES balances (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E9AE91A3DD ON users (balance_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE subscriptions DROP FOREIGN KEY FK_4778A01A76ED395');
        $this->addSql('ALTER TABLE subscriptions DROP FOREIGN KEY FK_4778A01ED5CA9E6');
        $this->addSql('DROP INDEX IDX_4778A01A76ED395 ON subscriptions');
        $this->addSql('DROP INDEX IDX_4778A01ED5CA9E6 ON subscriptions');
        $this->addSql('ALTER TABLE subscriptions DROP user_id, DROP service_id');
        $this->addSql('ALTER TABLE transactions DROP FOREIGN KEY FK_EAA81A4CAE91A3DD');
        $this->addSql('ALTER TABLE transactions DROP FOREIGN KEY FK_EAA81A4CED5CA9E6');
        $this->addSql('DROP INDEX IDX_EAA81A4CAE91A3DD ON transactions');
        $this->addSql('DROP INDEX IDX_EAA81A4CED5CA9E6 ON transactions');
        $this->addSql('ALTER TABLE transactions DROP balance_id, DROP service_id');
        $this->addSql('ALTER TABLE users DROP FOREIGN KEY FK_1483A5E9AE91A3DD');
        $this->addSql('DROP INDEX UNIQ_1483A5E9AE91A3DD ON users');
        $this->addSql('ALTER TABLE users DROP balance_id');
    }
}
