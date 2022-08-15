<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220815043527 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE api_user_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE notification_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE api_user (
          id INT NOT NULL,
          username VARCHAR(180) NOT NULL,
          roles JSON NOT NULL,
          password VARCHAR(255) NOT NULL,
          PRIMARY KEY(id)
        )');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_AC64A0BAF85E0677 ON api_user (username)');
        $this->addSql('CREATE TABLE client (
          id UUID NOT NULL,
          first_name VARCHAR(32) NOT NULL,
          last_name VARCHAR(32) NOT NULL,
          email VARCHAR(255) NOT NULL,
          phone_number VARCHAR(35) NOT NULL,
          PRIMARY KEY(id)
        )');
        $this->addSql('COMMENT ON COLUMN client.id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE notification (
          id INT NOT NULL,
          client_id UUID DEFAULT NULL,
          channel VARCHAR(32) NOT NULL,
          content TEXT NOT NULL,
          PRIMARY KEY(id)
        )');
        $this->addSql('CREATE INDEX IDX_BF5476CA19EB6921 ON notification (client_id)');
        $this->addSql('COMMENT ON COLUMN notification.client_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE messenger_messages (
          id BIGSERIAL NOT NULL,
          body TEXT NOT NULL,
          headers TEXT NOT NULL,
          queue_name VARCHAR(190) NOT NULL,
          created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL,
          available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL,
          delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL,
          PRIMARY KEY(id)
        )');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('CREATE
        OR REPLACE FUNCTION notify_messenger_messages() RETURNS TRIGGER AS $$ BEGIN PERFORM pg_notify(
          \'messenger_messages\', NEW.queue_name::text
        ); RETURN NEW; END; $$ LANGUAGE plpgsql;');
        $this->addSql('DROP TRIGGER IF EXISTS notify_trigger ON messenger_messages;');
        $this->addSql('CREATE TRIGGER notify_trigger AFTER INSERT
        OR
        UPDATE
          ON messenger_messages FOR EACH ROW EXECUTE PROCEDURE notify_messenger_messages();');
        $this->addSql('ALTER TABLE
          notification
        ADD
          CONSTRAINT FK_BF5476CA19EB6921 FOREIGN KEY (client_id) REFERENCES client (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE notification DROP CONSTRAINT FK_BF5476CA19EB6921');
        $this->addSql('DROP SEQUENCE api_user_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE notification_id_seq CASCADE');
        $this->addSql('DROP TABLE api_user');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE notification');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
