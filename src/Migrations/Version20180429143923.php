<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180429143923 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE challenge_groups (challenges_id INT NOT NULL, challenges_groups_id INT NOT NULL, INDEX IDX_3D09AB195EE78BA (challenges_id), INDEX IDX_3D09AB1AE3D98CB (challenges_groups_id), PRIMARY KEY(challenges_id, challenges_groups_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE challenge_groups ADD CONSTRAINT FK_3D09AB195EE78BA FOREIGN KEY (challenges_id) REFERENCES challenges (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE challenge_groups ADD CONSTRAINT FK_3D09AB1AE3D98CB FOREIGN KEY (challenges_groups_id) REFERENCES challenges_groups (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE challenges_challenges_groups');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE challenges_challenges_groups (challenges_id INT NOT NULL, challenges_groups_id INT NOT NULL, INDEX IDX_3612811C95EE78BA (challenges_id), INDEX IDX_3612811CAE3D98CB (challenges_groups_id), PRIMARY KEY(challenges_id, challenges_groups_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE challenges_challenges_groups ADD CONSTRAINT FK_3612811C95EE78BA FOREIGN KEY (challenges_id) REFERENCES challenges (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE challenges_challenges_groups ADD CONSTRAINT FK_3612811CAE3D98CB FOREIGN KEY (challenges_groups_id) REFERENCES challenges_groups (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE challenge_groups');
    }
}
