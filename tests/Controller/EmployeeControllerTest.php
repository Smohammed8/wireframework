<?php

namespace App\Test\Controller;

use App\Entity\Employee;
use App\Repository\EmployeeRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class EmployeeControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EmployeeRepository $repository;
    private string $path = '/employee/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Employee::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Employee index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $originalNumObjectsInRepository = count($this->repository->findAll());

        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'employee[firstName]' => 'Testing',
            'employee[fatherName]' => 'Testing',
            'employee[lastName]' => 'Testing',
            'employee[gender]' => 'Testing',
            'employee[dateOfBirth]' => 'Testing',
            'employee[phone]' => 'Testing',
            'employee[birthPlace]' => 'Testing',
            'employee[photo]' => 'Testing',
            'employee[bloodGroup]' => 'Testing',
            'employee[eyeColor]' => 'Testing',
            'employee[email]' => 'Testing',
            'employee[idNumber]' => 'Testing',
            'employee[pentionNumber]' => 'Testing',
            'employee[createdAt]' => 'Testing',
            'employee[firstNameAm]' => 'Testing',
            'employee[fatherNameAm]' => 'Testing',
            'employee[lastNameAm]' => 'Testing',
            'employee[updatedAt]' => 'Testing',
            'employee[employementDate]' => 'Testing',
            'employee[employeeTitle]' => 'Testing',
            'employee[educationallevel]' => 'Testing',
            'employee[martitalStatus]' => 'Testing',
            'employee[ethnicity]' => 'Testing',
            'employee[religion]' => 'Testing',
            'employee[fieldOfStudy]' => 'Testing',
            'employee[employmentType]' => 'Testing',
            'employee[employeeCurrentStatus]' => 'Testing',
            'employee[nationality]' => 'Testing',
            'employee[employeeCategory]' => 'Testing',
            'employee[position]' => 'Testing',
        ]);

        self::assertResponseRedirects('/employee/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Employee();
        $fixture->setFirstName('My Title');
        $fixture->setFatherName('My Title');
        $fixture->setLastName('My Title');
        $fixture->setGender('My Title');
        $fixture->setDateOfBirth('My Title');
        $fixture->setPhone('My Title');
        $fixture->setBirthPlace('My Title');
        $fixture->setPhoto('My Title');
        $fixture->setBloodGroup('My Title');
        $fixture->setEyeColor('My Title');
        $fixture->setEmail('My Title');
        $fixture->setIdNumber('My Title');
        $fixture->setPentionNumber('My Title');
        $fixture->setCreatedAt('My Title');
        $fixture->setFirstNameAm('My Title');
        $fixture->setFatherNameAm('My Title');
        $fixture->setLastNameAm('My Title');
        $fixture->setUpdatedAt('My Title');
        $fixture->setEmployementDate('My Title');
        $fixture->setEmployeeTitle('My Title');
        $fixture->setEducationallevel('My Title');
        $fixture->setMartitalStatus('My Title');
        $fixture->setEthnicity('My Title');
        $fixture->setReligion('My Title');
        $fixture->setFieldOfStudy('My Title');
        $fixture->setEmploymentType('My Title');
        $fixture->setEmployeeCurrentStatus('My Title');
        $fixture->setNationality('My Title');
        $fixture->setEmployeeCategory('My Title');
        $fixture->setPosition('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Employee');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Employee();
        $fixture->setFirstName('My Title');
        $fixture->setFatherName('My Title');
        $fixture->setLastName('My Title');
        $fixture->setGender('My Title');
        $fixture->setDateOfBirth('My Title');
        $fixture->setPhone('My Title');
        $fixture->setBirthPlace('My Title');
        $fixture->setPhoto('My Title');
        $fixture->setBloodGroup('My Title');
        $fixture->setEyeColor('My Title');
        $fixture->setEmail('My Title');
        $fixture->setIdNumber('My Title');
        $fixture->setPentionNumber('My Title');
        $fixture->setCreatedAt('My Title');
        $fixture->setFirstNameAm('My Title');
        $fixture->setFatherNameAm('My Title');
        $fixture->setLastNameAm('My Title');
        $fixture->setUpdatedAt('My Title');
        $fixture->setEmployementDate('My Title');
        $fixture->setEmployeeTitle('My Title');
        $fixture->setEducationallevel('My Title');
        $fixture->setMartitalStatus('My Title');
        $fixture->setEthnicity('My Title');
        $fixture->setReligion('My Title');
        $fixture->setFieldOfStudy('My Title');
        $fixture->setEmploymentType('My Title');
        $fixture->setEmployeeCurrentStatus('My Title');
        $fixture->setNationality('My Title');
        $fixture->setEmployeeCategory('My Title');
        $fixture->setPosition('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'employee[firstName]' => 'Something New',
            'employee[fatherName]' => 'Something New',
            'employee[lastName]' => 'Something New',
            'employee[gender]' => 'Something New',
            'employee[dateOfBirth]' => 'Something New',
            'employee[phone]' => 'Something New',
            'employee[birthPlace]' => 'Something New',
            'employee[photo]' => 'Something New',
            'employee[bloodGroup]' => 'Something New',
            'employee[eyeColor]' => 'Something New',
            'employee[email]' => 'Something New',
            'employee[idNumber]' => 'Something New',
            'employee[pentionNumber]' => 'Something New',
            'employee[createdAt]' => 'Something New',
            'employee[firstNameAm]' => 'Something New',
            'employee[fatherNameAm]' => 'Something New',
            'employee[lastNameAm]' => 'Something New',
            'employee[updatedAt]' => 'Something New',
            'employee[employementDate]' => 'Something New',
            'employee[employeeTitle]' => 'Something New',
            'employee[educationallevel]' => 'Something New',
            'employee[martitalStatus]' => 'Something New',
            'employee[ethnicity]' => 'Something New',
            'employee[religion]' => 'Something New',
            'employee[fieldOfStudy]' => 'Something New',
            'employee[employmentType]' => 'Something New',
            'employee[employeeCurrentStatus]' => 'Something New',
            'employee[nationality]' => 'Something New',
            'employee[employeeCategory]' => 'Something New',
            'employee[position]' => 'Something New',
        ]);

        self::assertResponseRedirects('/employee/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getFirstName());
        self::assertSame('Something New', $fixture[0]->getFatherName());
        self::assertSame('Something New', $fixture[0]->getLastName());
        self::assertSame('Something New', $fixture[0]->getGender());
        self::assertSame('Something New', $fixture[0]->getDateOfBirth());
        self::assertSame('Something New', $fixture[0]->getPhone());
        self::assertSame('Something New', $fixture[0]->getBirthPlace());
        self::assertSame('Something New', $fixture[0]->getPhoto());
        self::assertSame('Something New', $fixture[0]->getBloodGroup());
        self::assertSame('Something New', $fixture[0]->getEyeColor());
        self::assertSame('Something New', $fixture[0]->getEmail());
        self::assertSame('Something New', $fixture[0]->getIdNumber());
        self::assertSame('Something New', $fixture[0]->getPentionNumber());
        self::assertSame('Something New', $fixture[0]->getCreatedAt());
        self::assertSame('Something New', $fixture[0]->getFirstNameAm());
        self::assertSame('Something New', $fixture[0]->getFatherNameAm());
        self::assertSame('Something New', $fixture[0]->getLastNameAm());
        self::assertSame('Something New', $fixture[0]->getUpdatedAt());
        self::assertSame('Something New', $fixture[0]->getEmployementDate());
        self::assertSame('Something New', $fixture[0]->getEmployeeTitle());
        self::assertSame('Something New', $fixture[0]->getEducationallevel());
        self::assertSame('Something New', $fixture[0]->getMartitalStatus());
        self::assertSame('Something New', $fixture[0]->getEthnicity());
        self::assertSame('Something New', $fixture[0]->getReligion());
        self::assertSame('Something New', $fixture[0]->getFieldOfStudy());
        self::assertSame('Something New', $fixture[0]->getEmploymentType());
        self::assertSame('Something New', $fixture[0]->getEmployeeCurrentStatus());
        self::assertSame('Something New', $fixture[0]->getNationality());
        self::assertSame('Something New', $fixture[0]->getEmployeeCategory());
        self::assertSame('Something New', $fixture[0]->getPosition());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Employee();
        $fixture->setFirstName('My Title');
        $fixture->setFatherName('My Title');
        $fixture->setLastName('My Title');
        $fixture->setGender('My Title');
        $fixture->setDateOfBirth('My Title');
        $fixture->setPhone('My Title');
        $fixture->setBirthPlace('My Title');
        $fixture->setPhoto('My Title');
        $fixture->setBloodGroup('My Title');
        $fixture->setEyeColor('My Title');
        $fixture->setEmail('My Title');
        $fixture->setIdNumber('My Title');
        $fixture->setPentionNumber('My Title');
        $fixture->setCreatedAt('My Title');
        $fixture->setFirstNameAm('My Title');
        $fixture->setFatherNameAm('My Title');
        $fixture->setLastNameAm('My Title');
        $fixture->setUpdatedAt('My Title');
        $fixture->setEmployementDate('My Title');
        $fixture->setEmployeeTitle('My Title');
        $fixture->setEducationallevel('My Title');
        $fixture->setMartitalStatus('My Title');
        $fixture->setEthnicity('My Title');
        $fixture->setReligion('My Title');
        $fixture->setFieldOfStudy('My Title');
        $fixture->setEmploymentType('My Title');
        $fixture->setEmployeeCurrentStatus('My Title');
        $fixture->setNationality('My Title');
        $fixture->setEmployeeCategory('My Title');
        $fixture->setPosition('My Title');

        $this->repository->save($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/employee/');
    }
}
