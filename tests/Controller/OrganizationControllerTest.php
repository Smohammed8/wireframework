<?php

namespace App\Test\Controller;

use App\Entity\Organization;
use App\Repository\OrganizationRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class OrganizationControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private OrganizationRepository $repository;
    private string $path = '/organization/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Organization::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Organization index');

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
            'organization[name]' => 'Testing',
            'organization[moto]' => 'Testing',
            'organization[logo]' => 'Testing',
            'organization[tel]' => 'Testing',
            'organization[fax]' => 'Testing',
            'organization[pobox]' => 'Testing',
            'organization[leader]' => 'Testing',
        ]);

        self::assertResponseRedirects('/organization/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Organization();
        $fixture->setName('My Title');
        $fixture->setMoto('My Title');
        $fixture->setLogo('My Title');
        $fixture->setTel('My Title');
        $fixture->setFax('My Title');
        $fixture->setPobox('My Title');
        $fixture->setLeader('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Organization');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Organization();
        $fixture->setName('My Title');
        $fixture->setMoto('My Title');
        $fixture->setLogo('My Title');
        $fixture->setTel('My Title');
        $fixture->setFax('My Title');
        $fixture->setPobox('My Title');
        $fixture->setLeader('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'organization[name]' => 'Something New',
            'organization[moto]' => 'Something New',
            'organization[logo]' => 'Something New',
            'organization[tel]' => 'Something New',
            'organization[fax]' => 'Something New',
            'organization[pobox]' => 'Something New',
            'organization[leader]' => 'Something New',
        ]);

        self::assertResponseRedirects('/organization/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getName());
        self::assertSame('Something New', $fixture[0]->getMoto());
        self::assertSame('Something New', $fixture[0]->getLogo());
        self::assertSame('Something New', $fixture[0]->getTel());
        self::assertSame('Something New', $fixture[0]->getFax());
        self::assertSame('Something New', $fixture[0]->getPobox());
        self::assertSame('Something New', $fixture[0]->getLeader());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Organization();
        $fixture->setName('My Title');
        $fixture->setMoto('My Title');
        $fixture->setLogo('My Title');
        $fixture->setTel('My Title');
        $fixture->setFax('My Title');
        $fixture->setPobox('My Title');
        $fixture->setLeader('My Title');

        $this->repository->save($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/organization/');
    }
}
