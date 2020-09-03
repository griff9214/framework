<?php

declare(strict_types=1);

namespace Migration;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200825130347 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IDX_5F9E962A4B89032C');
        $this->addSql('CREATE TEMPORARY TABLE __temp__comments AS SELECT id, post_id, date, author, text FROM comments');
        $this->addSql('DROP TABLE comments');
        $this->addSql('CREATE TABLE comments (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, post_id INTEGER DEFAULT NULL, date DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , author VARCHAR(255) NOT NULL COLLATE BINARY, text CLOB NOT NULL COLLATE BINARY, CONSTRAINT FK_5F9E962A4B89032C FOREIGN KEY (post_id) REFERENCES posts (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO comments (id, post_id, date, author, text) SELECT id, post_id, date, author, text FROM __temp__comments');
        $this->addSql('DROP TABLE __temp__comments');
        $this->addSql('CREATE INDEX IDX_5F9E962A4B89032C ON comments (post_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__posts AS SELECT id, create_date, title, content_short, content_full, meta_title, meta_keywords, meta_description, update_date FROM posts');
        $this->addSql('DROP TABLE posts');
        $this->addSql('CREATE TABLE posts (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, create_date DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , title VARCHAR(255) NOT NULL COLLATE BINARY, content_short CLOB NOT NULL COLLATE BINARY, content_full CLOB NOT NULL COLLATE BINARY, meta_title VARCHAR(255) NOT NULL COLLATE BINARY, meta_keywords CLOB NOT NULL COLLATE BINARY, meta_description CLOB NOT NULL COLLATE BINARY, update_date DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        )');
        $this->addSql('INSERT INTO posts (id, create_date, title, content_short, content_full, meta_title, meta_keywords, meta_description, update_date) SELECT id, create_date, title, content_short, content_full, meta_title, meta_keywords, meta_description, update_date FROM __temp__posts');
        $this->addSql('DROP TABLE __temp__posts');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IDX_5F9E962A4B89032C');
        $this->addSql('CREATE TEMPORARY TABLE __temp__comments AS SELECT id, post_id, date, author, text FROM comments');
        $this->addSql('DROP TABLE comments');
        $this->addSql('CREATE TABLE comments (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, post_id INTEGER DEFAULT NULL, date DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , author VARCHAR(255) NOT NULL, text CLOB NOT NULL)');
        $this->addSql('INSERT INTO comments (id, post_id, date, author, text) SELECT id, post_id, date, author, text FROM __temp__comments');
        $this->addSql('DROP TABLE __temp__comments');
        $this->addSql('CREATE INDEX IDX_5F9E962A4B89032C ON comments (post_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__posts AS SELECT id, create_date, update_date, title, content_short, content_full, meta_title, meta_keywords, meta_description FROM posts');
        $this->addSql('DROP TABLE posts');
        $this->addSql('CREATE TABLE posts (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, create_date DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , title VARCHAR(255) NOT NULL, content_short CLOB NOT NULL, content_full CLOB NOT NULL, meta_title VARCHAR(255) NOT NULL, meta_keywords CLOB NOT NULL, meta_description CLOB NOT NULL, update_date DATETIME DEFAULT \'NULL --(DC2Type:datetime_immutable)\' --(DC2Type:datetime_immutable)
        )');
        $this->addSql('INSERT INTO posts (id, create_date, update_date, title, content_short, content_full, meta_title, meta_keywords, meta_description) SELECT id, create_date, update_date, title, content_short, content_full, meta_title, meta_keywords, meta_description FROM __temp__posts');
        $this->addSql('DROP TABLE __temp__posts');
    }
}
