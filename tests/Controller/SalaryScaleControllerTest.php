<?php

namespace App\Test\Controller;

use App\Entity\SalaryScale;
use App\Repository\SalaryScaleRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SalaryScaleControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private SalaryScaleRepository $repository;
    private string $path = '/salary/scale/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(SalaryScale::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('SalaryScale index');

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
            'salary_scale[startSalary]' => 'Testing',
            'salary_scale[one]' => 'Testing',
            'salary_scale[two]' => 'Testing',
            'salary_scale[three]' => 'Testing',
            'salary_scale[four]' => 'Testing',
            'salary_scale[five]' => 'Testing',
            'salary_scale[six]' => 'Testing',
            'salary_scale[seven]' => 'Testing',
            'salary_scale[eight]' => 'Testing',
            'salary_scale[nine]' => 'Testing',
            'salary_scale[ceilSalary]' => 'Testing',
            'salary_scale[createdAt]' => 'Testing',
            'salary_scale[updatedAt]' => 'Testing',
            'salary_scale[level]' => 'Testing',
            'salary_scale[user]' => 'Testing',
        ]);

        self::assertResponseRedirects('/salary/scale/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new SalaryScale();
        $fixture->setStartSalary('My Title');
        $fixture->setOne('My Title');
        $fixture->setTwo('My Title');
        $fixture->setThree('My Title');
        $fixture->setFour('My Title');
        $fixture->setFive('My Title');
        $fixture->setSix('My Title');
        $fixture->setSeven('My Title');
        $fixture->setEight('My Title');
        $fixture->setNine('My Title');
        $fixture->setCeilSalary('My Title');
        $fixture->setCreatedAt('My Title');
        $fixture->setUpdatedAt('My Title');
        $fixture->setLevel('My Title');
        $fixture->setUser('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('SalaryScale');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new SalaryScale();
        $fixture->setStartSalary('My Title');
        $fixture->setOne('My Title');
        $fixture->setTwo('My Title');
        $fixture->setThree('My Title');
        $fixture->setFour('My Title');
        $fixture->setFive('My Title');
        $fixture->setSix('My Title');
        $fixture->setSeven('My Title');
        $fixture->setEight('My Title');
        $fixture->setNine('My Title');
        $fixture->setCeilSalary('My Title');
        $fixture->setCreatedAt('My Title');
        $fixture->setUpdatedAt('My Title');
        $fixture->setLevel('My Title');
        $fixture->setUser('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'salary_scale[startSalary]' => 'Something New',
            'salary_scale[one]' => 'Something New',
            'salary_scale[two]' => 'Something New',
            'salary_scale[three]' => 'Something New',
            'salary_scale[four]' => 'Something New',
            'salary_scale[five]' => 'Something New',
            'salary_scale[six]' => 'Something New',
            'salary_scale[seven]' => 'Something New',
            'salary_scale[eight]' => 'Something New',
            'salary_scale[nine]' => 'Something New',
            'salary_scale[ceilSalary]' => 'Something New',
            'salary_scale[createdAt]' => 'Something New',
            'salary_scale[updatedAt]' => 'Something New',
            'salary_scale[level]' => 'Something New',
            'salary_scale[user]' => 'Something New',
        ]);

        self::assertResponseRedirects('/salary/scale/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getStartSalary());
        self::assertSame('Something New', $fixture[0]->getOne());
        self::assertSame('Something New', $fixture[0]->getTwo());
        self::assertSame('Something New', $fixture[0]->getThree());
        self::assertSame('Something New', $fixture[0]->getFour());
        self::assertSame('Something New', $fixture[0]->getFive());
        self::assertSame('Something New', $fixture[0]->getSix());
        self::assertSame('Something New', $fixture[0]->getSeven());
        self::assertSame('Something New', $fixture[0]->getEight());
        self::assertSame('Something New', $fixture[0]->getNine());
        self::assertSame('Something New', $fixture[0]->getCeilSalary());
        self::assertSame('Something New', $fixture[0]->getCreatedAt());
        self::assertSame('Something New', $fixture[0]->getUpdatedAt());
        self::assertSame('Something New', $fixture[0]->getLevel());
        self::assertSame('Something New', $fixture[0]->getUser());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new SalaryScale();
        $fixture->setStartSalary('My Title');
        $fixture->setOne('My Title');
        $fixture->setTwo('My Title');
        $fixture->setThree('My Title');
        $fixture->setFour('My Title');
        $fixture->setFive('My Title');
        $fixture->setSix('My Title');
        $fixture->setSeven('My Title');
        $fixture->setEight('My Title');
        $fixture->setNine('My Title');
        $fixture->setCeilSalary('My Title');
        $fixture->setCreatedAt('My Title');
        $fixture->setUpdatedAt('My Title');
        $fixture->setLevel('My Title');
        $fixture->setUser('My Title');

        $this->repository->save($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/salary/scale/');
    }
}
