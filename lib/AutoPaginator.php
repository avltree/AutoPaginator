<?php

namespace Avltree\Paginator;

/**
 * Extension for \Zend_Paginator. Provides a way to iterate through all elements provided by the underlying adapter.
 *
 * @package Avltree\Paginator
 * @author Przemysław Saracen <p.saracen@gmail.com>
 */
final class AutoPaginator extends \Zend_Paginator
{
    /**
     * @var bool
     */
    private $isInfiniteModeEnabled = false;

    /**
     * Enables or disables the infinite mode for the paginator. If enabled, using the paginator as an iterator will
     * ignore the limit of items per page and retrieve all items provided by its current adapter. In doing so it will
     * not bypass the pagination mechanics, but it will internally iterate through remaining pages.
     *
     * @param $isInfinite
     */
    public function setInfiniteMode($isInfinite)
    {
        $this->isInfiniteModeEnabled = (bool)$isInfinite;
    }

    /**
     * @inheritDoc
     */
    public function getIterator()
    {
        if ($this->isInfiniteModeEnabled) {
            return $this->getItemsGenerator();
        }

        return parent::getIterator();
    }

    /**
     * Provides the generator function which will iterate through remaining pages, yields a single item.
     *
     * @return \Generator
     */
    private function getItemsGenerator()
    {
        $currentPage = $this->getCurrentPageNumber();

        while ($currentPage <= count($this)) {
            foreach (parent::getIterator() as $item) {
                yield $item;
            }

            $this->setCurrentPageNumber(++$currentPage);
        }
    }
}