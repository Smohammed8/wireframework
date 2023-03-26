<?php

namespace App\Test\Controller;

use App\Entity\InternalExperience;
use App\Repository\InternalExperienceRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class InternalExperienceControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private InternalExperienceRepository $repository;
    private string $path = '/internal/experience/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(InternalExperience::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('InternalExperience index');

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
            'internal_experience[startDate]' => 'Testing',
            'internal_experience[endDate]' => 'Testing',
            'internal_experience[createdAt]' => 'Testing',
            'internal_experience[employee]' => 'Testing',
            'internal_experience[unit]' => 'Testing',
            'internal_experience[jobTitle]' => 'Testing',
            'internal_experience[user]' => 'Testing',
        ]);

        self::assertResponseRedirects('/internal/experience/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new InternalExperience();
        $fixture->setStartDate('My Title');
        $fixture->setEndDate('My Title');
        $fixture->setCreatedAt('My Title');
        $fixture->setEmployee('My Title');
        $fixture->setUnit('My Title');
        $fixture->setJobTitle('My Title');
        $fixture->setUser('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('InternalExperience');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new InternalExperience();
        $fixture->setStartDate('My Title');
        $fixture->setEndDate('My Title');
        $fixture->setCreatedAt('My Title');
        $fixture->setEmployee('My Title');
        $fixture->setUnit('My Title');
        $fixture->setJobTitle('My Title');
        $fixture->setUser('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'internal_experience[startDate]' => 'Something New',
            'internal_experience[endDate]' => 'Something New',
            'internal_experience[createdAt]' => 'Something New',
            'internal_experience[employee]' => 'Something New',
            'internal_experience[unit]' => 'Something New',
            'internal_experience[jobTitle]' => 'Something New',
            'internal_experience[user]' => 'Something New',
        ]);

        self::assertResponseRedirects('/internal/experience/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getStartDate());
        self::assertSame('Something New', $fixture[0]->getEndDate());
        self::assertSame('Something New', $fixture[0]->getCreatedAt());
        self::assertSame('Something New', $fixture[0]->getEmployee());
        self::assertSame('Something New', $fixture[0]->getUnit());
        self::assertSame('Something New', $fixture[0]->getJobTitle());
        self::assertSame('Something New', $fixture[0]->getUser());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new InternalExperience();
        $fixture->setStartDate('My Title');
        $fixture->setEndDate('My Title');
        $fixture->setCreatedAt('My Title');
        $fixture->setEmployee('My Title');
        $fixture->setUnit('My Title');
        $fixture->setJobTitle('My Title');
        $fixture->setUser('My Title');

        $this->repository->save($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/internal/experience/');
    }
}
