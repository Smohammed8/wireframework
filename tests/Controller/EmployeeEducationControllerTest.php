<?php

namespace App\Test\Controller;

use App\Entity\EmployeeEducation;
use App\Repository\EmployeeEducationRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class EmployeeEducationControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EmployeeEducationRepository $repository;
    private string $path = '/employee/education/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(EmployeeEducation::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('EmployeeEducation index');

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
            'employee_education[institution]' => 'Testing',
            'employee_education[startDate]' => 'Testing',
            'employee_education[endDate]' => 'Testing',
            'employee_education[file]' => 'Testing',
            'employee_education[employee]' => 'Testing',
            'employee_education[educationLevel]' => 'Testing',
        ]);

        self::assertResponseRedirects('/employee/education/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new EmployeeEducation();
        $fixture->setInstitution('My Title');
        $fixture->setStartDate('My Title');
        $fixture->setEndDate('My Title');
        $fixture->setFile('My Title');
        $fixture->setEmployee('My Title');
        $fixture->setEducationLevel('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('EmployeeEducation');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new EmployeeEducation();
        $fixture->setInstitution('My Title');
        $fixture->setStartDate('My Title');
        $fixture->setEndDate('My Title');
        $fixture->setFile('My Title');
        $fixture->setEmployee('My Title');
        $fixture->setEducationLevel('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'employee_education[institution]' => 'Something New',
            'employee_education[startDate]' => 'Something New',
            'employee_education[endDate]' => 'Something New',
            'employee_education[file]' => 'Something New',
            'employee_education[employee]' => 'Something New',
            'employee_education[educationLevel]' => 'Something New',
        ]);

        self::assertResponseRedirects('/employee/education/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getInstitution());
        self::assertSame('Something New', $fixture[0]->getStartDate());
        self::assertSame('Something New', $fixture[0]->getEndDate());
        self::assertSame('Something New', $fixture[0]->getFile());
        self::assertSame('Something New', $fixture[0]->getEmployee());
        self::assertSame('Something New', $fixture[0]->getEducationLevel());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new EmployeeEducation();
        $fixture->setInstitution('My Title');
        $fixture->setStartDate('My Title');
        $fixture->setEndDate('My Title');
        $fixture->setFile('My Title');
        $fixture->setEmployee('My Title');
        $fixture->setEducationLevel('My Title');

        $this->repository->save($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/employee/education/');
    }
}
