<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230410221855 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE contract_range (id INT AUTO_INCREMENT NOT NULL, employee_id INT DEFAULT NULL, start_date DATETIME NOT NULL, end_date DATETIME DEFAULT NULL, status VARCHAR(100) DEFAULT NULL, INDEX IDX_D086C66D8C03F15C (employee_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE country (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, flag VARCHAR(255) DEFAULT NULL, nationality VARCHAR(100) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE educational_level (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, weight VARCHAR(100) DEFAULT NULL, description LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE emergency_contact (id INT AUTO_INCREMENT NOT NULL, employee_id INT DEFAULT NULL, relationship_id INT DEFAULT NULL, first_name VARCHAR(100) NOT NULL, last_name VARCHAR(100) NOT NULL, phone VARCHAR(100) DEFAULT NULL, INDEX IDX_FE1C61908C03F15C (employee_id), INDEX IDX_FE1C61902C41D668 (relationship_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE employee (id INT AUTO_INCREMENT NOT NULL, employee_title_id INT DEFAULT NULL, educationallevel_id INT DEFAULT NULL, martital_status_id INT DEFAULT NULL, ethnicity_id INT DEFAULT NULL, religion_id INT DEFAULT NULL, field_of_study_id INT DEFAULT NULL, employment_type_id INT DEFAULT NULL, employee_current_status_id INT DEFAULT NULL, nationality_id INT DEFAULT NULL, employee_category_id INT DEFAULT NULL, position_id INT DEFAULT NULL, first_name VARCHAR(100) NOT NULL, father_name VARCHAR(100) NOT NULL, last_name VARCHAR(100) NOT NULL, gender VARCHAR(50) NOT NULL, date_of_birth DATETIME NOT NULL, phone VARCHAR(50) DEFAULT NULL, birth_place VARCHAR(100) DEFAULT NULL, photo VARCHAR(255) DEFAULT NULL, blood_group VARCHAR(50) DEFAULT NULL, eye_color VARCHAR(100) DEFAULT NULL, email VARCHAR(100) DEFAULT NULL, id_number VARCHAR(100) DEFAULT NULL, pention_number VARCHAR(100) DEFAULT NULL, created_at DATETIME NOT NULL, first_name_am VARCHAR(100) DEFAULT NULL, father_name_am VARCHAR(100) DEFAULT NULL, last_name_am VARCHAR(100) DEFAULT NULL, updated_at DATETIME DEFAULT NULL, employement_date DATETIME NOT NULL, institution VARCHAR(100) DEFAULT NULL, INDEX IDX_5D9F75A19AA0D67A (employee_title_id), INDEX IDX_5D9F75A1841B6FA1 (educationallevel_id), INDEX IDX_5D9F75A127C0F63B (martital_status_id), INDEX IDX_5D9F75A1A2AE4F5 (ethnicity_id), INDEX IDX_5D9F75A1B7850CBD (religion_id), INDEX IDX_5D9F75A19E9C46D5 (field_of_study_id), INDEX IDX_5D9F75A11BCDC34A (employment_type_id), INDEX IDX_5D9F75A1B6B6EF30 (employee_current_status_id), INDEX IDX_5D9F75A11C9DA55 (nationality_id), INDEX IDX_5D9F75A193605C9F (employee_category_id), INDEX IDX_5D9F75A1DD842E46 (position_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE employee_category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, expired_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE employee_education (id INT AUTO_INCREMENT NOT NULL, employee_id INT DEFAULT NULL, education_level_id INT DEFAULT NULL, user_id INT DEFAULT NULL, institution VARCHAR(100) NOT NULL, start_date DATETIME NOT NULL, end_date DATETIME NOT NULL, file VARCHAR(100) DEFAULT NULL, created_at DATETIME NOT NULL, INDEX IDX_DE9A36908C03F15C (employee_id), INDEX IDX_DE9A3690D7A5352E (education_level_id), INDEX IDX_DE9A3690A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE employee_family (id INT AUTO_INCREMENT NOT NULL, relationship_id INT DEFAULT NULL, first_name VARCHAR(100) NOT NULL, last_name VARCHAR(100) NOT NULL, phone VARCHAR(100) DEFAULT NULL, INDEX IDX_8CD7E5CE2C41D668 (relationship_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE employee_language (id INT AUTO_INCREMENT NOT NULL, employee_id INT DEFAULT NULL, language_id INT DEFAULT NULL, speaking VARCHAR(50) NOT NULL, reading VARCHAR(50) NOT NULL, writing VARCHAR(50) NOT NULL, listening VARCHAR(50) NOT NULL, INDEX IDX_44E420728C03F15C (employee_id), INDEX IDX_44E4207282F1BAF4 (language_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE employee_title (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, accronomy VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE employment_status (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, description LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE employment_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, description LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ethnicity (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE external_experience (id INT AUTO_INCREMENT NOT NULL, employee_id INT DEFAULT NULL, job_title VARCHAR(100) NOT NULL, company_name VARCHAR(100) NOT NULL, start_date DATETIME NOT NULL, end_date DATETIME DEFAULT NULL, clearance VARCHAR(255) DEFAULT NULL, INDEX IDX_1F6E4ED18C03F15C (employee_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE field_of_study (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE internal_experience (id INT AUTO_INCREMENT NOT NULL, employee_id INT DEFAULT NULL, unit_id INT DEFAULT NULL, job_title_id INT DEFAULT NULL, user_id INT DEFAULT NULL, start_date DATETIME NOT NULL, end_date DATETIME NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_DF78BE2B8C03F15C (employee_id), INDEX IDX_DF78BE2BF8BD700D (unit_id), INDEX IDX_DF78BE2B6DD822C6 (job_title_id), INDEX IDX_DF78BE2BA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE job_title (id INT AUTO_INCREMENT NOT NULL, job_title_category_id INT DEFAULT NULL, min_educational_requirment_id INT DEFAULT NULL, level_id INT DEFAULT NULL, name VARCHAR(100) NOT NULL, INDEX IDX_2A6AC51B30957A58 (job_title_category_id), INDEX IDX_2A6AC51B5F47D4A2 (min_educational_requirment_id), INDEX IDX_2A6AC51B5FB14BA7 (level_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE job_title_category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, description LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE job_title_fields (id INT AUTO_INCREMENT NOT NULL, job_title_id INT DEFAULT NULL, field_of_study_id INT DEFAULT NULL, INDEX IDX_BF27638E6DD822C6 (job_title_id), INDEX IDX_BF27638E9E9C46D5 (field_of_study_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE language (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, is_local TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE level (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE marital_status (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE organization (id INT AUTO_INCREMENT NOT NULL, leader_id INT DEFAULT NULL, name VARCHAR(100) NOT NULL, moto VARCHAR(255) DEFAULT NULL, logo VARCHAR(255) DEFAULT NULL, tel VARCHAR(100) DEFAULT NULL, fax VARCHAR(100) DEFAULT NULL, pobox VARCHAR(50) DEFAULT NULL, UNIQUE INDEX UNIQ_C1EE637C73154ED4 (leader_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE payroll_setting (id INT AUTO_INCREMENT NOT NULL, income_start NUMERIC(10, 2) NOT NULL, income_to NUMERIC(10, 2) NOT NULL, income_tax NUMERIC(10, 2) NOT NULL, deduction NUMERIC(10, 2) NOT NULL, pension NUMERIC(10, 2) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE position (id INT AUTO_INCREMENT NOT NULL, unit_id INT DEFAULT NULL, job_title_id INT DEFAULT NULL, no_of_vacants INT NOT NULL, INDEX IDX_462CE4F5F8BD700D (unit_id), INDEX IDX_462CE4F56DD822C6 (job_title_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE position_code (id INT AUTO_INCREMENT NOT NULL, position_id INT DEFAULT NULL, employee_id INT DEFAULT NULL, code VARCHAR(100) DEFAULT NULL, INDEX IDX_648D1EC6DD842E46 (position_id), UNIQUE INDEX UNIQ_648D1EC68C03F15C (employee_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE relationship (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, sex VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE religion (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE salary_scale (id INT AUTO_INCREMENT NOT NULL, level_id INT DEFAULT NULL, user_id INT DEFAULT NULL, start_salary VARCHAR(100) NOT NULL, one VARCHAR(100) NOT NULL, two VARCHAR(100) NOT NULL, three VARCHAR(100) NOT NULL, four VARCHAR(100) NOT NULL, five VARCHAR(100) NOT NULL, six VARCHAR(100) NOT NULL, seven VARCHAR(100) NOT NULL, eight VARCHAR(100) NOT NULL, nine VARCHAR(100) NOT NULL, ceil_salary VARCHAR(100) NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_79A1C6245FB14BA7 (level_id), INDEX IDX_79A1C624A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE unit (id INT AUTO_INCREMENT NOT NULL, parent_unit_id INT DEFAULT NULL, leader_id INT DEFAULT NULL, name VARCHAR(100) NOT NULL, email VARCHAR(100) DEFAULT NULL, phone VARCHAR(50) DEFAULT NULL, INDEX IDX_DCBB0C538AF5044B (parent_unit_id), INDEX IDX_DCBB0C5373154ED4 (leader_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, first_name VARCHAR(100) NOT NULL, father_name VARCHAR(100) NOT NULL, phone VARCHAR(50) DEFAULT NULL, gender VARCHAR(50) NOT NULL, email VARCHAR(100) DEFAULT NULL, last_login DATETIME DEFAULT NULL, status VARCHAR(100) NOT NULL, photo VARCHAR(255) DEFAULT NULL, created_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE contract_range ADD CONSTRAINT FK_D086C66D8C03F15C FOREIGN KEY (employee_id) REFERENCES employee (id)');
        $this->addSql('ALTER TABLE emergency_contact ADD CONSTRAINT FK_FE1C61908C03F15C FOREIGN KEY (employee_id) REFERENCES employee (id)');
        $this->addSql('ALTER TABLE emergency_contact ADD CONSTRAINT FK_FE1C61902C41D668 FOREIGN KEY (relationship_id) REFERENCES relationship (id)');
        $this->addSql('ALTER TABLE employee ADD CONSTRAINT FK_5D9F75A19AA0D67A FOREIGN KEY (employee_title_id) REFERENCES employee_title (id)');
        $this->addSql('ALTER TABLE employee ADD CONSTRAINT FK_5D9F75A1841B6FA1 FOREIGN KEY (educationallevel_id) REFERENCES educational_level (id)');
        $this->addSql('ALTER TABLE employee ADD CONSTRAINT FK_5D9F75A127C0F63B FOREIGN KEY (martital_status_id) REFERENCES marital_status (id)');
        $this->addSql('ALTER TABLE employee ADD CONSTRAINT FK_5D9F75A1A2AE4F5 FOREIGN KEY (ethnicity_id) REFERENCES ethnicity (id)');
        $this->addSql('ALTER TABLE employee ADD CONSTRAINT FK_5D9F75A1B7850CBD FOREIGN KEY (religion_id) REFERENCES religion (id)');
        $this->addSql('ALTER TABLE employee ADD CONSTRAINT FK_5D9F75A19E9C46D5 FOREIGN KEY (field_of_study_id) REFERENCES field_of_study (id)');
        $this->addSql('ALTER TABLE employee ADD CONSTRAINT FK_5D9F75A11BCDC34A FOREIGN KEY (employment_type_id) REFERENCES employment_type (id)');
        $this->addSql('ALTER TABLE employee ADD CONSTRAINT FK_5D9F75A1B6B6EF30 FOREIGN KEY (employee_current_status_id) REFERENCES employment_status (id)');
        $this->addSql('ALTER TABLE employee ADD CONSTRAINT FK_5D9F75A11C9DA55 FOREIGN KEY (nationality_id) REFERENCES country (id)');
        $this->addSql('ALTER TABLE employee ADD CONSTRAINT FK_5D9F75A193605C9F FOREIGN KEY (employee_category_id) REFERENCES employee_category (id)');
        $this->addSql('ALTER TABLE employee ADD CONSTRAINT FK_5D9F75A1DD842E46 FOREIGN KEY (position_id) REFERENCES position (id)');
        $this->addSql('ALTER TABLE employee_education ADD CONSTRAINT FK_DE9A36908C03F15C FOREIGN KEY (employee_id) REFERENCES employee (id)');
        $this->addSql('ALTER TABLE employee_education ADD CONSTRAINT FK_DE9A3690D7A5352E FOREIGN KEY (education_level_id) REFERENCES educational_level (id)');
        $this->addSql('ALTER TABLE employee_education ADD CONSTRAINT FK_DE9A3690A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE employee_family ADD CONSTRAINT FK_8CD7E5CE2C41D668 FOREIGN KEY (relationship_id) REFERENCES relationship (id)');
        $this->addSql('ALTER TABLE employee_language ADD CONSTRAINT FK_44E420728C03F15C FOREIGN KEY (employee_id) REFERENCES employee (id)');
        $this->addSql('ALTER TABLE employee_language ADD CONSTRAINT FK_44E4207282F1BAF4 FOREIGN KEY (language_id) REFERENCES language (id)');
        $this->addSql('ALTER TABLE external_experience ADD CONSTRAINT FK_1F6E4ED18C03F15C FOREIGN KEY (employee_id) REFERENCES employee (id)');
        $this->addSql('ALTER TABLE internal_experience ADD CONSTRAINT FK_DF78BE2B8C03F15C FOREIGN KEY (employee_id) REFERENCES employee (id)');
        $this->addSql('ALTER TABLE internal_experience ADD CONSTRAINT FK_DF78BE2BF8BD700D FOREIGN KEY (unit_id) REFERENCES unit (id)');
        $this->addSql('ALTER TABLE internal_experience ADD CONSTRAINT FK_DF78BE2B6DD822C6 FOREIGN KEY (job_title_id) REFERENCES job_title (id)');
        $this->addSql('ALTER TABLE internal_experience ADD CONSTRAINT FK_DF78BE2BA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE job_title ADD CONSTRAINT FK_2A6AC51B30957A58 FOREIGN KEY (job_title_category_id) REFERENCES job_title_category (id)');
        $this->addSql('ALTER TABLE job_title ADD CONSTRAINT FK_2A6AC51B5F47D4A2 FOREIGN KEY (min_educational_requirment_id) REFERENCES educational_level (id)');
        $this->addSql('ALTER TABLE job_title ADD CONSTRAINT FK_2A6AC51B5FB14BA7 FOREIGN KEY (level_id) REFERENCES level (id)');
        $this->addSql('ALTER TABLE job_title_fields ADD CONSTRAINT FK_BF27638E6DD822C6 FOREIGN KEY (job_title_id) REFERENCES job_title (id)');
        $this->addSql('ALTER TABLE job_title_fields ADD CONSTRAINT FK_BF27638E9E9C46D5 FOREIGN KEY (field_of_study_id) REFERENCES field_of_study (id)');
        $this->addSql('ALTER TABLE organization ADD CONSTRAINT FK_C1EE637C73154ED4 FOREIGN KEY (leader_id) REFERENCES employee (id)');
        $this->addSql('ALTER TABLE position ADD CONSTRAINT FK_462CE4F5F8BD700D FOREIGN KEY (unit_id) REFERENCES unit (id)');
        $this->addSql('ALTER TABLE position ADD CONSTRAINT FK_462CE4F56DD822C6 FOREIGN KEY (job_title_id) REFERENCES job_title (id)');
        $this->addSql('ALTER TABLE position_code ADD CONSTRAINT FK_648D1EC6DD842E46 FOREIGN KEY (position_id) REFERENCES position (id)');
        $this->addSql('ALTER TABLE position_code ADD CONSTRAINT FK_648D1EC68C03F15C FOREIGN KEY (employee_id) REFERENCES employee (id)');
        $this->addSql('ALTER TABLE salary_scale ADD CONSTRAINT FK_79A1C6245FB14BA7 FOREIGN KEY (level_id) REFERENCES level (id)');
        $this->addSql('ALTER TABLE salary_scale ADD CONSTRAINT FK_79A1C624A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE unit ADD CONSTRAINT FK_DCBB0C538AF5044B FOREIGN KEY (parent_unit_id) REFERENCES unit (id)');
        $this->addSql('ALTER TABLE unit ADD CONSTRAINT FK_DCBB0C5373154ED4 FOREIGN KEY (leader_id) REFERENCES employee (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contract_range DROP FOREIGN KEY FK_D086C66D8C03F15C');
        $this->addSql('ALTER TABLE emergency_contact DROP FOREIGN KEY FK_FE1C61908C03F15C');
        $this->addSql('ALTER TABLE emergency_contact DROP FOREIGN KEY FK_FE1C61902C41D668');
        $this->addSql('ALTER TABLE employee DROP FOREIGN KEY FK_5D9F75A19AA0D67A');
        $this->addSql('ALTER TABLE employee DROP FOREIGN KEY FK_5D9F75A1841B6FA1');
        $this->addSql('ALTER TABLE employee DROP FOREIGN KEY FK_5D9F75A127C0F63B');
        $this->addSql('ALTER TABLE employee DROP FOREIGN KEY FK_5D9F75A1A2AE4F5');
        $this->addSql('ALTER TABLE employee DROP FOREIGN KEY FK_5D9F75A1B7850CBD');
        $this->addSql('ALTER TABLE employee DROP FOREIGN KEY FK_5D9F75A19E9C46D5');
        $this->addSql('ALTER TABLE employee DROP FOREIGN KEY FK_5D9F75A11BCDC34A');
        $this->addSql('ALTER TABLE employee DROP FOREIGN KEY FK_5D9F75A1B6B6EF30');
        $this->addSql('ALTER TABLE employee DROP FOREIGN KEY FK_5D9F75A11C9DA55');
        $this->addSql('ALTER TABLE employee DROP FOREIGN KEY FK_5D9F75A193605C9F');
        $this->addSql('ALTER TABLE employee DROP FOREIGN KEY FK_5D9F75A1DD842E46');
        $this->addSql('ALTER TABLE employee_education DROP FOREIGN KEY FK_DE9A36908C03F15C');
        $this->addSql('ALTER TABLE employee_education DROP FOREIGN KEY FK_DE9A3690D7A5352E');
        $this->addSql('ALTER TABLE employee_education DROP FOREIGN KEY FK_DE9A3690A76ED395');
        $this->addSql('ALTER TABLE employee_family DROP FOREIGN KEY FK_8CD7E5CE2C41D668');
        $this->addSql('ALTER TABLE employee_language DROP FOREIGN KEY FK_44E420728C03F15C');
        $this->addSql('ALTER TABLE employee_language DROP FOREIGN KEY FK_44E4207282F1BAF4');
        $this->addSql('ALTER TABLE external_experience DROP FOREIGN KEY FK_1F6E4ED18C03F15C');
        $this->addSql('ALTER TABLE internal_experience DROP FOREIGN KEY FK_DF78BE2B8C03F15C');
        $this->addSql('ALTER TABLE internal_experience DROP FOREIGN KEY FK_DF78BE2BF8BD700D');
        $this->addSql('ALTER TABLE internal_experience DROP FOREIGN KEY FK_DF78BE2B6DD822C6');
        $this->addSql('ALTER TABLE internal_experience DROP FOREIGN KEY FK_DF78BE2BA76ED395');
        $this->addSql('ALTER TABLE job_title DROP FOREIGN KEY FK_2A6AC51B30957A58');
        $this->addSql('ALTER TABLE job_title DROP FOREIGN KEY FK_2A6AC51B5F47D4A2');
        $this->addSql('ALTER TABLE job_title DROP FOREIGN KEY FK_2A6AC51B5FB14BA7');
        $this->addSql('ALTER TABLE job_title_fields DROP FOREIGN KEY FK_BF27638E6DD822C6');
        $this->addSql('ALTER TABLE job_title_fields DROP FOREIGN KEY FK_BF27638E9E9C46D5');
        $this->addSql('ALTER TABLE organization DROP FOREIGN KEY FK_C1EE637C73154ED4');
        $this->addSql('ALTER TABLE position DROP FOREIGN KEY FK_462CE4F5F8BD700D');
        $this->addSql('ALTER TABLE position DROP FOREIGN KEY FK_462CE4F56DD822C6');
        $this->addSql('ALTER TABLE position_code DROP FOREIGN KEY FK_648D1EC6DD842E46');
        $this->addSql('ALTER TABLE position_code DROP FOREIGN KEY FK_648D1EC68C03F15C');
        $this->addSql('ALTER TABLE salary_scale DROP FOREIGN KEY FK_79A1C6245FB14BA7');
        $this->addSql('ALTER TABLE salary_scale DROP FOREIGN KEY FK_79A1C624A76ED395');
        $this->addSql('ALTER TABLE unit DROP FOREIGN KEY FK_DCBB0C538AF5044B');
        $this->addSql('ALTER TABLE unit DROP FOREIGN KEY FK_DCBB0C5373154ED4');
        $this->addSql('DROP TABLE contract_range');
        $this->addSql('DROP TABLE country');
        $this->addSql('DROP TABLE educational_level');
        $this->addSql('DROP TABLE emergency_contact');
        $this->addSql('DROP TABLE employee');
        $this->addSql('DROP TABLE employee_category');
        $this->addSql('DROP TABLE employee_education');
        $this->addSql('DROP TABLE employee_family');
        $this->addSql('DROP TABLE employee_language');
        $this->addSql('DROP TABLE employee_title');
        $this->addSql('DROP TABLE employment_status');
        $this->addSql('DROP TABLE employment_type');
        $this->addSql('DROP TABLE ethnicity');
        $this->addSql('DROP TABLE external_experience');
        $this->addSql('DROP TABLE field_of_study');
        $this->addSql('DROP TABLE internal_experience');
        $this->addSql('DROP TABLE job_title');
        $this->addSql('DROP TABLE job_title_category');
        $this->addSql('DROP TABLE job_title_fields');
        $this->addSql('DROP TABLE language');
        $this->addSql('DROP TABLE level');
        $this->addSql('DROP TABLE marital_status');
        $this->addSql('DROP TABLE organization');
        $this->addSql('DROP TABLE payroll_setting');
        $this->addSql('DROP TABLE position');
        $this->addSql('DROP TABLE position_code');
        $this->addSql('DROP TABLE relationship');
        $this->addSql('DROP TABLE religion');
        $this->addSql('DROP TABLE salary_scale');
        $this->addSql('DROP TABLE unit');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
