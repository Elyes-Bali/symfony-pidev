<?php

namespace App\Test\Controller;

use App\Entity\Commentaire;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CommentaireControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;
    private string $path = '/commentaire/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->manager->getRepository(Commentaire::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Commentaire index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'commentaire[contenu]' => 'Testing',
            'commentaire[nom]' => 'Testing',
            'commentaire[datenow]' => 'Testing',
            'commentaire[post]' => 'Testing',
        ]);

        self::assertResponseRedirects('/sweet/food/');

        self::assertSame(1, $this->getRepository()->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Commentaire();
        $fixture->setContenu('My Title');
        $fixture->setNom('My Title');
        $fixture->setDatenow('My Title');
        $fixture->setPost('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Commentaire');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Commentaire();
        $fixture->setContenu('Value');
        $fixture->setNom('Value');
        $fixture->setDatenow('Value');
        $fixture->setPost('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'commentaire[contenu]' => 'Something New',
            'commentaire[nom]' => 'Something New',
            'commentaire[datenow]' => 'Something New',
            'commentaire[post]' => 'Something New',
        ]);

        self::assertResponseRedirects('/commentaire/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getContenu());
        self::assertSame('Something New', $fixture[0]->getNom());
        self::assertSame('Something New', $fixture[0]->getDatenow());
        self::assertSame('Something New', $fixture[0]->getPost());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Commentaire();
        $fixture->setContenu('Value');
        $fixture->setNom('Value');
        $fixture->setDatenow('Value');
        $fixture->setPost('Value');

        $this->manager->remove($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/commentaire/');
        self::assertSame(0, $this->repository->count([]));
    }
}
