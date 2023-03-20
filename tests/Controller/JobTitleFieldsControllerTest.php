<?php

namespace App\Test\Controller;

use App\Entity\JobTitleFields;
use App\Repository\JobTitleFieldsRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class JobTitleFieldsControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private JobTitleFieldsRepository $repository;
    private string $path = '/job/title/fields/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(JobTitleFields::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('JobTitleField index');

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
            'job_title_field[jobTitle]' => 'Testing',
            'job_title_field[fieldOfStudy]' => 'Testing',
        ]);

        self::assertResponseRedirects('/job/title/fields/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new JobTitleFields();
        $fixture->setJobTitle('My Title');
        $fixture->setFieldOfStudy('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('JobTitleField');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new JobTitleFields();
        $fixture->setJobTitle('My Title');
        $fixture->setFieldOfStudy('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'job_title_field[jobTitle]' => 'Something New',
            'job_title_field[fieldOfStudy]' => 'Something New',
        ]);

        self::assertResponseRedirects('/job/title/fields/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getJobTitle());
        self::assertSame('Something New', $fixture[0]->getFieldOfStudy());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new JobTitleFields();
        $fixture->setJobTitle('My Title');
        $fixture->setFieldOfStudy('My Title');

        $this->repository->save($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/job/title/fields/');
    }
}
