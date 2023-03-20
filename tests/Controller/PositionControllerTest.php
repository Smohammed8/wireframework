<?php

namespace App\Test\Controller;

use App\Entity\Position;
use App\Repository\PositionRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PositionControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private PositionRepository $repository;
    private string $path = '/position/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Position::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Position index');

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
            'position[NoOfVacants]' => 'Testing',
            'position[unit]' => 'Testing',
            'position[jobTitle]' => 'Testing',
        ]);

        self::assertResponseRedirects('/position/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Position();
        $fixture->setNoOfVacants('My Title');
        $fixture->setUnit('My Title');
        $fixture->setJobTitle('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Position');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Position();
        $fixture->setNoOfVacants('My Title');
        $fixture->setUnit('My Title');
        $fixture->setJobTitle('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'position[NoOfVacants]' => 'Something New',
            'position[unit]' => 'Something New',
            'position[jobTitle]' => 'Something New',
        ]);

        self::assertResponseRedirects('/position/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getNoOfVacants());
        self::assertSame('Something New', $fixture[0]->getUnit());
        self::assertSame('Something New', $fixture[0]->getJobTitle());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Position();
        $fixture->setNoOfVacants('My Title');
        $fixture->setUnit('My Title');
        $fixture->setJobTitle('My Title');

        $this->repository->save($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/position/');
    }
}
