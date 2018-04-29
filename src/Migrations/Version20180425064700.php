<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180425064700 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE user_challenges (challenges_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_A0D2610C95EE78BA (challenges_id), INDEX IDX_A0D2610CA76ED395 (user_id), PRIMARY KEY(challenges_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_challenges ADD CONSTRAINT FK_A0D2610C95EE78BA FOREIGN KEY (challenges_id) REFERENCES challenges (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_challenges ADD CONSTRAINT FK_A0D2610CA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE challenges DROP user_challenges');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE user_challenges');
        $this->addSql('ALTER TABLE challenges ADD user_challenges VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci');
    }
}
