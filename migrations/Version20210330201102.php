<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210330201102 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE languages (id CHAR(36) NOT NULL COMMENT \'(DC2Type:Language_LanguageId)\', name VARCHAR(255) NOT NULL, short_name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_A0D153795E237E06 (name), UNIQUE INDEX UNIQ_A0D153793EE4B093 (short_name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users_native_languages (user_id CHAR(36) NOT NULL COMMENT \'(DC2Type:Users_UserId)\', language_id CHAR(36) NOT NULL COMMENT \'(DC2Type:Language_LanguageId)\', INDEX IDX_804AC943A76ED395 (user_id), INDEX IDX_804AC94382F1BAF4 (language_id), PRIMARY KEY(user_id, language_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users_studying_languages (user_id CHAR(36) NOT NULL COMMENT \'(DC2Type:Users_UserId)\', language_id CHAR(36) NOT NULL COMMENT \'(DC2Type:Language_LanguageId)\', INDEX IDX_6EF5E04A76ED395 (user_id), INDEX IDX_6EF5E0482F1BAF4 (language_id), PRIMARY KEY(user_id, language_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE users_native_languages ADD CONSTRAINT FK_804AC943A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE users_native_languages ADD CONSTRAINT FK_804AC94382F1BAF4 FOREIGN KEY (language_id) REFERENCES languages (id)');
        $this->addSql('ALTER TABLE users_studying_languages ADD CONSTRAINT FK_6EF5E04A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE users_studying_languages ADD CONSTRAINT FK_6EF5E0482F1BAF4 FOREIGN KEY (language_id) REFERENCES languages (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE users_native_languages DROP FOREIGN KEY FK_804AC94382F1BAF4');
        $this->addSql('ALTER TABLE users_studying_languages DROP FOREIGN KEY FK_6EF5E0482F1BAF4');
        $this->addSql('DROP TABLE languages');
        $this->addSql('DROP TABLE users_native_languages');
        $this->addSql('DROP TABLE users_studying_languages');
    }
}
