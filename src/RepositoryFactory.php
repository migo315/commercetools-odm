<?php

namespace BestIt\CommercetoolsODM;

use BestIt\CommercetoolsODM\Mapping\ClassMetadataInterface;
use BestIt\CommercetoolsODM\Model\DefaultRepository;
use BestIt\CTAsyncPool\PoolAwareTrait;
use BestIt\CTAsyncPool\PoolInterface;
use Doctrine\Common\Persistence\ObjectRepository;

/**
 * Factory to provide the system with repositories.
 * @author lange <lange@bestit-online.de>
 * @package BestIt\CommercetoolsODM
 * @version $id$
 */
class RepositoryFactory implements RepositoryFactoryInterface
{
    use PoolAwareTrait;

    /**
     * The default repository for this factory.
     * @var string
     */
    const DEFAULT_REPOSITORY = DefaultRepository::class;

    public function __construct(PoolInterface $pool = null)
    {
        if ($pool) {
            $this->setPool($pool);
        }
    }

    /**
     * Gets the repository for a class.
     * @param DocumentManagerInterface $documentManager
     * @param string $className
     * @return ObjectRepository
     * @todo Exception.
     */
    public function getRepository(DocumentManagerInterface $documentManager, string $className): ObjectRepository
    {
        $metadata = $documentManager->getClassMetadata($className);
        $repository = static::DEFAULT_REPOSITORY;

        if (($metadata instanceof ClassMetadataInterface) && ($tmp = $metadata->getRepository())) {
            $repository = $tmp;
        }

        return new $repository($metadata, $documentManager, $documentManager->getQueryHelper(), $this->getPool());
    }
}
