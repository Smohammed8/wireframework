<?php

namespace App\Test\Controller;

use App\Entity\EmergencyContact;
use App\Repository\EmergencyContactRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class EmergencyContactControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EmergencyContactRepository $repository;
    private string $path = '/emergency/contact/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(EmergencyContact::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('EmergencyContact index');

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
            'emergency_contact[firstName]' => 'Testing',
            'emergency_contact[lastName]' => 'Testing',
            'emergency_contact[phone]' => 'Testing',
            'emergency_contact[employee]' => 'Testing',
            'emergency_contact[relationship]' => 'Testing',
        ]);

        self::assertResponseRedirects('/emergency/contact/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new EmergencyContact();
        $fixture->setFirstName('My Title');
        $fixture->setLastName('My Title');
        $fixture->setPhone('My Title');
        $fixture->setEmployee('My Title');
        $fixture->setRelationship('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('EmergencyContact');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new EmergencyContact();
        $fixture->setFirstName('My Title');
        $fixture->setLastName('My Title');
        $fixture->setPhone('My Title');
        $fixture->setEmployee('My Title');
        $fixture->setRelationship('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'emergency_contact[firstName]' => 'Something New',
            'emergency_contact[lastName]' => 'Something New',
            'emergency_contact[phone]' => 'Something New',
            'emergency_contact[employee]' => 'Something New',
            'emergency_contact[relationship]' => 'Something New',
        ]);

        self::assertResponseRedirects('/emergency/contact/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getFirstName());
        self::assertSame('Something New', $fixture[0]->getLastName());
        self::assertSame('Something New', $fixture[0]->getPhone());
        self::assertSame('Something New', $fixture[0]->getEmployee());
        self::assertSame('Something New', $fixture[0]->getRelationship());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new EmergencyContact();
        $fixture->setFirstName('My Title');
        $fixture->setLastName('My Title');
        $fixture->setPhone('My Title');
        $fixture->setEmployee('My Title');
        $fixture->setRelationship('My Title');

        $this->repository->save($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/emergency/contact/');
    }
}
