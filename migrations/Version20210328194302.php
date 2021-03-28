<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210328194302 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql('
            create table users_auth_tokens
            (
                id int auto_increment,
                user_id CHAR(36) not null,
                refresh_token varchar(40) not null,
                access_token_expire_at datetime not null,
                refresh_token_expire_at datetime not null,
                created_at datetime default now() not null,
                access_token varchar(40) not null,
                constraint users_auth_tokens_pk
                    primary key (id),
                constraint users_auth_tokens_users_id_fk
                    foreign key (user_id) references users (id)
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB;
            
            create unique index users_auth_tokens_user_id_uindex
                on users_auth_tokens (user_id);
            
            create unique index users_auth_tokens_access_token_uindex
                on users_auth_tokens (access_token);
            
            create unique index users_auth_tokens_refresh_token_uindex
                on users_auth_tokens (refresh_token);
        ');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE users_auth_tokens');
    }
}
