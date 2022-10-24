<?php

declare(strict_types=1);

namespace LaminasTest\Paginator\ScrollingStyle;

use Laminas\Paginator\Adapter\ArrayAdapter;
use Laminas\Paginator\Paginator;
use Laminas\Paginator\ScrollingStyle\All;
use PHPUnit\Framework\TestCase;

use function array_combine;
use function assert;
use function range;

/**
 * @group      Laminas_Paginator
 * @covers  Laminas\Paginator\ScrollingStyle\All<extended>
 */
class AllTest extends TestCase
{
    private ?All $scrollingStyle;

    private ?Paginator $paginator;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->scrollingStyle = new All();
        $this->paginator      = new Paginator(new ArrayAdapter(range(1, 101)));
        $this->paginator->setItemCountPerPage(10);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown(): void
    {
        $this->scrollingStyle = null;
        $this->paginator      = null;
        parent::tearDown();
    }

    public function testGetsPages(): void
    {
        $expected = array_combine(range(1, 11), range(1, 11));

        assert($this->scrollingStyle instanceof All);
        assert($this->paginator instanceof Paginator);

        $pages = $this->scrollingStyle->getPages($this->paginator);
        $this->assertEquals($expected, $pages);
    }

    public function testGetsNextAndPreviousPageForFirstPage(): void
    {
        assert($this->paginator instanceof Paginator);

        $this->paginator->setCurrentPageNumber(1);
        $pages = $this->paginator->getPages('All');

        $this->assertEquals(2, $pages->next);
    }

    public function testGetsNextAndPreviousPageForSecondPage(): void
    {
        assert($this->paginator instanceof Paginator);

        $this->paginator->setCurrentPageNumber(2);
        $pages = $this->paginator->getPages('All');
        $this->assertEquals(1, $pages->previous);
        $this->assertEquals(3, $pages->next);
    }

    public function testGetsNextAndPreviousPageForMiddlePage(): void
    {
        assert($this->paginator instanceof Paginator);

        $this->paginator->setCurrentPageNumber(6);
        $pages = $this->paginator->getPages('All');
        $this->assertEquals(5, $pages->previous);
        $this->assertEquals(7, $pages->next);
    }

    public function testGetsNextAndPreviousPageForSecondLastPage(): void
    {
        assert($this->paginator instanceof Paginator);

        $this->paginator->setCurrentPageNumber(10);
        $pages = $this->paginator->getPages('All');
        $this->assertEquals(9, $pages->previous);
        $this->assertEquals(11, $pages->next);
    }

    public function testGetsNextAndPreviousPageForLastPage(): void
    {
        assert($this->paginator instanceof Paginator);

        $this->paginator->setCurrentPageNumber(11);
        $pages = $this->paginator->getPages('All');
        $this->assertEquals(10, $pages->previous);
    }
}
