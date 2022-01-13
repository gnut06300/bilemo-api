<?php

namespace App\DataPersister;

use App\Entity\Customer;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Security;

class CustomerDataPersister implements ContextAwareDataPersisterInterface
{
    private $_entityManager;
    private $_request;
    private $_security;

    public function __construct(
        EntityManagerInterface $entityManager,
        RequestStack $request,
        Security $security
    )
    {
        $this->_entityManager = $entityManager;
        $this->_request = $request->getCurrentRequest();
        $this->_security = $security;
    }

    public function supports($data, array $context = []): bool
    {
        return $data instanceof Customer;
    }

    /**
     * Undocumented function
     *
     * @param Customer $data
     * @param array $context
     * @return void
     */
    public function persist($data, array $context = [])
    {
        // Set the client if it's a new customer
        if ($this->_request->getMethod() === 'POST') {
            $data->setClient($this->_security->getUser());
        }

        $this->_entityManager->persist($data);
        $this->_entityManager->flush();
    }

    public function remove($data, array $context = [])
    {
        $this->_entityManager->remove($data);
        $this->_entityManager->flush();
    }
}