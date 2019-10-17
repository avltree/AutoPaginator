<?php

namespace Avltree\Test\Paginator;

use Avltree\Paginator\AutoPaginator;

/**
 * @package Avltree\Test\Paginator
 * @see AutoPaginator
 * @author Przemysław Saracen <p.saracen@gmail.com>
 */
class AutoPaginatorTest extends \PHPUnit_Framework_TestCase
{
    public function testInfiniteModeRetrieveAll()
    {
        $paginator = $this->bootstrapTestPaginator(6, true);
        $itemsRetrieved = $this->retrievePaginatorItemsByForeach($paginator);

        $this->assertCount(6, $itemsRetrieved);
    }

    public function testInfiniteModeFromSpecifiedPage()
    {
        $paginator = $this->bootstrapTestPaginator(10, true, 2);
        $paginator->setCurrentPageNumber(3);
        $itemsRetrieved = $this->retrievePaginatorItemsByForeach($paginator);

        // 10 - 2 * 2 should be retrieved
        $this->assertCount(6, $itemsRetrieved);
        // The first item on page 3 should be Item 5
        $this->assertEquals('Item 5', $itemsRetrieved[0]);
    }

    public function testNormalMode()
    {
        $paginator = $this->bootstrapTestPaginator(6, false, 2);
        $paginator->setCurrentPageNumber(2);
        $itemsRetrieved = $this->retrievePaginatorItemsByForeach($paginator);

        // Should only retrieve 2 items in normal mode
        $this->assertCount(2, $itemsRetrieved);
        // The first item on page 2 should be Item 3
        $this->assertEquals('Item 3', $itemsRetrieved[0]);
    }

    /**
     * Shorthand for paginator initialization.
     *
     * @param $itemCount
     * @param $isInfiniteMode
     * @param int $itemCountPerPage
     * @return AutoPaginator
     * @throws \Zend_Paginator_Exception
     */
    private function bootstrapTestPaginator($itemCount, $isInfiniteMode, $itemCountPerPage = 1)
    {
        $testData = $this->generateDataSet($itemCount);
        $paginator = new AutoPaginator(new \Zend_Paginator_Adapter_Array($testData));
        $paginator->setInfiniteMode($isInfiniteMode);
        $paginator->setItemCountPerPage($itemCountPerPage);

        return $paginator;
    }

    /**
     * Generates simple test data.
     *
     * @param $itemCount
     * @return array
     */
    private function generateDataSet($itemCount)
    {
        if (!is_int($itemCount) && $itemCount < 0) {
            throw new \InvalidArgumentException('Item count must be a positive integer.');
        }

        return array_map(function ($item) {
            return 'Item ' . $item;
        }, range(1, $itemCount));
    }

    /**
     * Iterates through the provided paginator and collects the items into an array for testing purposes.
     *
     * @param AutoPaginator $paginator
     * @return array
     */
    private function retrievePaginatorItemsByForeach(AutoPaginator $paginator)
    {
        $items = [];

        foreach ($paginator as $item) {
            $items[] = $item;
        }

        return $items;
    }
}
