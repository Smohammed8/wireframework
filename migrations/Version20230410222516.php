<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230410222516 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
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
        $this->addSql('ALTER TABLE user ADD first_name VARCHAR(100) NOT NULL, ADD father_name VARCHAR(100) NOT NULL, ADD phone VARCHAR(50) DEFAULT NULL, ADD gender VARCHAR(50) NOT NULL, ADD email VARCHAR(100) DEFAULT NULL, ADD last_login DATETIME DEFAULT NULL, ADD status VARCHAR(100) NOT NULL, ADD photo VARCHAR(255) DEFAULT NULL, ADD created_at DATETIME DEFAULT NULL');
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
        $this->addSql('ALTER TABLE user DROP first_name, DROP father_name, DROP phone, DROP gender, DROP email, DROP last_login, DROP status, DROP photo, DROP created_at');
    }
}
