<?php

namespace BestIt\CommercetoolsODM\Tests\Repository;

use BestIt\CommercetoolsODM\DocumentManagerInterface;
use BestIt\CommercetoolsODM\Mapping\ClassMetadataInterface;
use BestIt\CommercetoolsODM\Model\ByKeySearchRepositoryInterface;
use BestIt\CommercetoolsODM\Model\ByKeySearchRepositoryTrait;
use BestIt\CommercetoolsODM\Repository\ObjectRepository;
use BestIt\CommercetoolsODM\Repository\ProductTypeRepository;
use BestIt\CommercetoolsODM\Tests\TestTraitsTrait;
use BestIt\CTAsyncPool\PoolInterface;
use Commercetools\Commons\Helper\QueryHelper;
use Commercetools\Core\Model\ProductType\ProductType;
use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject;

/**
 * Class ProductTypeRepositoryTest
 * @author blange <lange@bestit-online.de>
 * @package BestIt\CommercetoolsODM
 * @subpackage Repository
 * @version $id$
 */
class ProductTypeRepositoryTest extends TestCase
{
    use TestRepositoryTrait;
    use TestTraitsTrait;

    /**
     * The tested class.
     * @var ProductTypeRepository
     */
    protected $fixture = null;

    /**
     * Returns the class name for the repository.
     * @return string
     */
    protected function getRepositoryClass(): string
    {
        return ProductTypeRepository::class;
    }

    /**
     * Returns the names of the used traits.
     * @return array
     */
    protected function getUsedTraitNames(): array
    {
        return [
            ByKeySearchRepositoryTrait::class
        ];
    }

    /**
     * Checks the class interfaces.
     * @return void
     */
    public function testInterfaces()
    {
        static::assertInstanceOf(ObjectRepository::class, $this->fixture);
        static::assertInstanceOf(ByKeySearchRepositoryInterface::class, $this->fixture);
    }

    /**
     * Checks the save call.
     * @return void
     */
    public function testSave()
    {
        $type = new ProductType();

        $this->documentManager
            ->expects(static::once())
            ->method('flush');

        $this->documentManager
            ->expects(static::once())
            ->method('persist')
            ->with($type);

        $this->fixture->save($type);
    }
}
