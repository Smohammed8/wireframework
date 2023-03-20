<?php

namespace App\Test\Controller;

use App\Entity\EmployeeLanguage;
use App\Repository\EmployeeLanguageRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class EmployeeLanguageControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EmployeeLanguageRepository $repository;
    private string $path = '/employee/language/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(EmployeeLanguage::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('EmployeeLanguage index');

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
            'employee_language[speaking]' => 'Testing',
            'employee_language[reading]' => 'Testing',
            'employee_language[writing]' => 'Testing',
            'employee_language[listening]' => 'Testing',
            'employee_language[employee]' => 'Testing',
            'employee_language[language]' => 'Testing',
        ]);

        self::assertResponseRedirects('/employee/language/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new EmployeeLanguage();
        $fixture->setSpeaking('My Title');
        $fixture->setReading('My Title');
        $fixture->setWriting('My Title');
        $fixture->setListening('My Title');
        $fixture->setEmployee('My Title');
        $fixture->setLanguage('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('EmployeeLanguage');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new EmployeeLanguage();
        $fixture->setSpeaking('My Title');
        $fixture->setReading('My Title');
        $fixture->setWriting('My Title');
        $fixture->setListening('My Title');
        $fixture->setEmployee('My Title');
        $fixture->setLanguage('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'employee_language[speaking]' => 'Something New',
            'employee_language[reading]' => 'Something New',
            'employee_language[writing]' => 'Something New',
            'employee_language[listening]' => 'Something New',
            'employee_language[employee]' => 'Something New',
            'employee_language[language]' => 'Something New',
        ]);

        self::assertResponseRedirects('/employee/language/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getSpeaking());
        self::assertSame('Something New', $fixture[0]->getReading());
        self::assertSame('Something New', $fixture[0]->getWriting());
        self::assertSame('Something New', $fixture[0]->getListening());
        self::assertSame('Something New', $fixture[0]->getEmployee());
        self::assertSame('Something New', $fixture[0]->getLanguage());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new EmployeeLanguage();
        $fixture->setSpeaking('My Title');
        $fixture->setReading('My Title');
        $fixture->setWriting('My Title');
        $fixture->setListening('My Title');
        $fixture->setEmployee('My Title');
        $fixture->setLanguage('My Title');

        $this->repository->save($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/employee/language/');
    }
}
