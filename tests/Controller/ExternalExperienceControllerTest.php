<?php

namespace App\Test\Controller;

use App\Entity\ExternalExperience;
use App\Repository\ExternalExperienceRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ExternalExperienceControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private ExternalExperienceRepository $repository;
    private string $path = '/external/experience/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(ExternalExperience::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('ExternalExperience index');

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
            'external_experience[jobTitle]' => 'Testing',
            'external_experience[companyName]' => 'Testing',
            'external_experience[startDate]' => 'Testing',
            'external_experience[endDate]' => 'Testing',
            'external_experience[clearance]' => 'Testing',
            'external_experience[employee]' => 'Testing',
        ]);

        self::assertResponseRedirects('/external/experience/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new ExternalExperience();
        $fixture->setJobTitle('My Title');
        $fixture->setCompanyName('My Title');
        $fixture->setStartDate('My Title');
        $fixture->setEndDate('My Title');
        $fixture->setClearance('My Title');
        $fixture->setEmployee('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('ExternalExperience');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new ExternalExperience();
        $fixture->setJobTitle('My Title');
        $fixture->setCompanyName('My Title');
        $fixture->setStartDate('My Title');
        $fixture->setEndDate('My Title');
        $fixture->setClearance('My Title');
        $fixture->setEmployee('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'external_experience[jobTitle]' => 'Something New',
            'external_experience[companyName]' => 'Something New',
            'external_experience[startDate]' => 'Something New',
            'external_experience[endDate]' => 'Something New',
            'external_experience[clearance]' => 'Something New',
            'external_experience[employee]' => 'Something New',
        ]);

        self::assertResponseRedirects('/external/experience/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getJobTitle());
        self::assertSame('Something New', $fixture[0]->getCompanyName());
        self::assertSame('Something New', $fixture[0]->getStartDate());
        self::assertSame('Something New', $fixture[0]->getEndDate());
        self::assertSame('Something New', $fixture[0]->getClearance());
        self::assertSame('Something New', $fixture[0]->getEmployee());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new ExternalExperience();
        $fixture->setJobTitle('My Title');
        $fixture->setCompanyName('My Title');
        $fixture->setStartDate('My Title');
        $fixture->setEndDate('My Title');
        $fixture->setClearance('My Title');
        $fixture->setEmployee('My Title');

        $this->repository->save($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/external/experience/');
    }
}
