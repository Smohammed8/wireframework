<?php

namespace App\Test\Controller;

use App\Entity\PayrollSetting;
use App\Repository\PayrollSettingRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PayrollSettingControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private PayrollSettingRepository $repository;
    private string $path = '/payroll/setting/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(PayrollSetting::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('PayrollSetting index');

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
            'payroll_setting[incomeStart]' => 'Testing',
            'payroll_setting[incomeTo]' => 'Testing',
            'payroll_setting[incomeTax]' => 'Testing',
            'payroll_setting[deduction]' => 'Testing',
            'payroll_setting[pension]' => 'Testing',
        ]);

        self::assertResponseRedirects('/payroll/setting/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new PayrollSetting();
        $fixture->setIncomeStart('My Title');
        $fixture->setIncomeTo('My Title');
        $fixture->setIncomeTax('My Title');
        $fixture->setDeduction('My Title');
        $fixture->setPension('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('PayrollSetting');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new PayrollSetting();
        $fixture->setIncomeStart('My Title');
        $fixture->setIncomeTo('My Title');
        $fixture->setIncomeTax('My Title');
        $fixture->setDeduction('My Title');
        $fixture->setPension('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'payroll_setting[incomeStart]' => 'Something New',
            'payroll_setting[incomeTo]' => 'Something New',
            'payroll_setting[incomeTax]' => 'Something New',
            'payroll_setting[deduction]' => 'Something New',
            'payroll_setting[pension]' => 'Something New',
        ]);

        self::assertResponseRedirects('/payroll/setting/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getIncomeStart());
        self::assertSame('Something New', $fixture[0]->getIncomeTo());
        self::assertSame('Something New', $fixture[0]->getIncomeTax());
        self::assertSame('Something New', $fixture[0]->getDeduction());
        self::assertSame('Something New', $fixture[0]->getPension());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new PayrollSetting();
        $fixture->setIncomeStart('My Title');
        $fixture->setIncomeTo('My Title');
        $fixture->setIncomeTax('My Title');
        $fixture->setDeduction('My Title');
        $fixture->setPension('My Title');

        $this->repository->save($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/payroll/setting/');
    }
}
