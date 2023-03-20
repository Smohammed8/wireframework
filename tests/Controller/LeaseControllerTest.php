<?php

namespace App\Test\Controller;

use App\Entity\Lease;
use App\Repository\LeaseRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LeaseControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private LeaseRepository $repository;
    private string $path = '/lease/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Lease::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Lease index');

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
            'lease[code]' => 'Testing',
            'lease[height]' => 'Testing',
            'lease[width]' => 'Testing',
            'lease[building]' => 'Testing',
            'lease[leaseIntialPrice]' => 'Testing',
            'lease[totalLeasePrice]' => 'Testing',
            'lease[yearlyPayment]' => 'Testing',
            'lease[north]' => 'Testing',
            'lease[south]' => 'Testing',
            'lease[east]' => 'Testing',
            'lease[west]' => 'Testing',
            'lease[mizan]' => 'Testing',
            'lease[kebele]' => 'Testing',
            'lease[level]' => 'Testing',
            'lease[planType]' => 'Testing',
        ]);

        self::assertResponseRedirects('/lease/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Lease();
        $fixture->setCode('My Title');
        $fixture->setHeight('My Title');
        $fixture->setWidth('My Title');
        $fixture->setBuilding('My Title');
        $fixture->setLeaseIntialPrice('My Title');
        $fixture->setTotalLeasePrice('My Title');
        $fixture->setYearlyPayment('My Title');
        $fixture->setNorth('My Title');
        $fixture->setSouth('My Title');
        $fixture->setEast('My Title');
        $fixture->setWest('My Title');
        $fixture->setMizan('My Title');
        $fixture->setKebele('My Title');
        $fixture->setLevel('My Title');
        $fixture->setPlanType('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Lease');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Lease();
        $fixture->setCode('My Title');
        $fixture->setHeight('My Title');
        $fixture->setWidth('My Title');
        $fixture->setBuilding('My Title');
        $fixture->setLeaseIntialPrice('My Title');
        $fixture->setTotalLeasePrice('My Title');
        $fixture->setYearlyPayment('My Title');
        $fixture->setNorth('My Title');
        $fixture->setSouth('My Title');
        $fixture->setEast('My Title');
        $fixture->setWest('My Title');
        $fixture->setMizan('My Title');
        $fixture->setKebele('My Title');
        $fixture->setLevel('My Title');
        $fixture->setPlanType('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'lease[code]' => 'Something New',
            'lease[height]' => 'Something New',
            'lease[width]' => 'Something New',
            'lease[building]' => 'Something New',
            'lease[leaseIntialPrice]' => 'Something New',
            'lease[totalLeasePrice]' => 'Something New',
            'lease[yearlyPayment]' => 'Something New',
            'lease[north]' => 'Something New',
            'lease[south]' => 'Something New',
            'lease[east]' => 'Something New',
            'lease[west]' => 'Something New',
            'lease[mizan]' => 'Something New',
            'lease[kebele]' => 'Something New',
            'lease[level]' => 'Something New',
            'lease[planType]' => 'Something New',
        ]);

        self::assertResponseRedirects('/lease/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getCode());
        self::assertSame('Something New', $fixture[0]->getHeight());
        self::assertSame('Something New', $fixture[0]->getWidth());
        self::assertSame('Something New', $fixture[0]->getBuilding());
        self::assertSame('Something New', $fixture[0]->getLeaseIntialPrice());
        self::assertSame('Something New', $fixture[0]->getTotalLeasePrice());
        self::assertSame('Something New', $fixture[0]->getYearlyPayment());
        self::assertSame('Something New', $fixture[0]->getNorth());
        self::assertSame('Something New', $fixture[0]->getSouth());
        self::assertSame('Something New', $fixture[0]->getEast());
        self::assertSame('Something New', $fixture[0]->getWest());
        self::assertSame('Something New', $fixture[0]->getMizan());
        self::assertSame('Something New', $fixture[0]->getKebele());
        self::assertSame('Something New', $fixture[0]->getLevel());
        self::assertSame('Something New', $fixture[0]->getPlanType());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Lease();
        $fixture->setCode('My Title');
        $fixture->setHeight('My Title');
        $fixture->setWidth('My Title');
        $fixture->setBuilding('My Title');
        $fixture->setLeaseIntialPrice('My Title');
        $fixture->setTotalLeasePrice('My Title');
        $fixture->setYearlyPayment('My Title');
        $fixture->setNorth('My Title');
        $fixture->setSouth('My Title');
        $fixture->setEast('My Title');
        $fixture->setWest('My Title');
        $fixture->setMizan('My Title');
        $fixture->setKebele('My Title');
        $fixture->setLevel('My Title');
        $fixture->setPlanType('My Title');

        $this->repository->save($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/lease/');
    }
}
