<?php

namespace App\Test\Controller;

use App\Entity\ContractRange;
use App\Repository\ContractRangeRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ContractRangeControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private ContractRangeRepository $repository;
    private string $path = '/contract/range/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(ContractRange::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('ContractRange index');

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
            'contract_range[startDate]' => 'Testing',
            'contract_range[endDate]' => 'Testing',
            'contract_range[status]' => 'Testing',
            'contract_range[employee]' => 'Testing',
        ]);

        self::assertResponseRedirects('/contract/range/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new ContractRange();
        $fixture->setStartDate('My Title');
        $fixture->setEndDate('My Title');
        $fixture->setStatus('My Title');
        $fixture->setEmployee('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('ContractRange');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new ContractRange();
        $fixture->setStartDate('My Title');
        $fixture->setEndDate('My Title');
        $fixture->setStatus('My Title');
        $fixture->setEmployee('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'contract_range[startDate]' => 'Something New',
            'contract_range[endDate]' => 'Something New',
            'contract_range[status]' => 'Something New',
            'contract_range[employee]' => 'Something New',
        ]);

        self::assertResponseRedirects('/contract/range/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getStartDate());
        self::assertSame('Something New', $fixture[0]->getEndDate());
        self::assertSame('Something New', $fixture[0]->getStatus());
        self::assertSame('Something New', $fixture[0]->getEmployee());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new ContractRange();
        $fixture->setStartDate('My Title');
        $fixture->setEndDate('My Title');
        $fixture->setStatus('My Title');
        $fixture->setEmployee('My Title');

        $this->repository->save($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/contract/range/');
    }
}
