<?php

namespace App\DataPersister;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class ProductDataPersister implements ContextAwareDataPersisterInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $_entityManager;
    private $_slugger;

    public function __construct(EntityManagerInterface $entityManager, SluggerInterface $slugger)
    {
        $this->_entityManager = $entityManager;
        $this->_slugger = $slugger;
    }

    /**
     * {@inheritdoc}
     */
    public function supports($data, array $context = []): bool
    {
        return $data instanceof Product;
    }

    /**
     * {@inheritdoc}
     */
    public function persist($data, array $context = [])
    {
        $data->setSlug(
            $this->_slugger
                ->slug(strtolower($data->getName())). '-' .uniqid()
        );
        $this->_entityManager->persist($data);
        $this->_entityManager->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function remove($data, array $context = [])
    {
        $this->_entityManager->remove($data);
        $this->_entityManager->flush();
    }
}