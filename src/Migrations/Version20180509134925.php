<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180509134925 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE user_milestone (user_id INT NOT NULL, milestone_id INT NOT NULL, is_completed TINYINT(1) NOT NULL, is_deleted TINYINT(1) NOT NULL, is_failed TINYINT(1) NOT NULL, INDEX IDX_4F4C0E66A76ED395 (user_id), INDEX IDX_4F4C0E664B3E2EDA (milestone_id), PRIMARY KEY(user_id, milestone_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_milestone ADD CONSTRAINT FK_4F4C0E66A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE user_milestone ADD CONSTRAINT FK_4F4C0E664B3E2EDA FOREIGN KEY (milestone_id) REFERENCES milestone (id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE user_milestone');
    }
}
