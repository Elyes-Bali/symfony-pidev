<?php

namespace App\Test\Controller;

use App\Entity\Circuit;
use App\Repository\CircuitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CircuitControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private CircuitRepository $repository;
    private string $path = '/circuit/';
    private EntityManagerInterface $manager;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Circuit::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Circuit index');

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
            'circuit[prix]' => 'Testing',
            'circuit[depart]' => 'Testing',
            'circuit[arrive]' => 'Testing',
            'circuit[temps]' => 'Testing',
            'circuit[categorie]' => 'Testing',
            'circuit[description]' => 'Testing',
            'circuit[pays]' => 'Testing',
            'circuit[destination]' => 'Testing',
        ]);

        self::assertResponseRedirects('/circuit/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Circuit();
        $fixture->setPrix('My Title');
        $fixture->setDepart('My Title');
        $fixture->setArrive('My Title');
        $fixture->setTemps('My Title');
        $fixture->setCategorie('My Title');
        $fixture->setDescription('My Title');
        $fixture->setPays('My Title');
        $fixture->setDestination('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Circuit');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Circuit();
        $fixture->setPrix('My Title');
        $fixture->setDepart('My Title');
        $fixture->setArrive('My Title');
        $fixture->setTemps('My Title');
        $fixture->setCategorie('My Title');
        $fixture->setDescription('My Title');
        $fixture->setPays('My Title');
        $fixture->setDestination('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'circuit[prix]' => 'Something New',
            'circuit[depart]' => 'Something New',
            'circuit[arrive]' => 'Something New',
            'circuit[temps]' => 'Something New',
            'circuit[categorie]' => 'Something New',
            'circuit[description]' => 'Something New',
            'circuit[pays]' => 'Something New',
            'circuit[destination]' => 'Something New',
        ]);

        self::assertResponseRedirects('/circuit/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getPrix());
        self::assertSame('Something New', $fixture[0]->getDepart());
        self::assertSame('Something New', $fixture[0]->getArrive());
        self::assertSame('Something New', $fixture[0]->getTemps());
        self::assertSame('Something New', $fixture[0]->getCategorie());
        self::assertSame('Something New', $fixture[0]->getDescription());
        self::assertSame('Something New', $fixture[0]->getPays());
        self::assertSame('Something New', $fixture[0]->getDestination());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Circuit();
        $fixture->setPrix('My Title');
        $fixture->setDepart('My Title');
        $fixture->setArrive('My Title');
        $fixture->setTemps('My Title');
        $fixture->setCategorie('My Title');
        $fixture->setDescription('My Title');
        $fixture->setPays('My Title');
        $fixture->setDestination('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/circuit/');
    }
}
