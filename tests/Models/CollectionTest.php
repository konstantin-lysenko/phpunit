<?php
use PHPUnit\Framework\TestCase;
use App\Models\Collection;

class CollectionTest extends TestCase
{

    protected $collection;

    public function setUp() : void
    {
        $this->collection = new Collection();
    }

    /** @test */
    public function emptyCollectionReturnsNoItems()
    {
        $this->assertEmpty( $this->collection->get() );
    }

    /** @test */
    public function countIsCorrect()
    {
        $data = [
            'apple',
            'apple',
            'pencil',
            null,
            '1',
            1,
            0
        ];

        $this->collection->put( $data );

        $this->assertCount( \count($data), $this->collection->get() );
        $this->assertEquals( \count($data), $this->collection->count() );
    }
}