<?php

namespace App\Model;

use App\View\View;

class Pagination
{
    protected const DEFAULT_LISTING_SIZE = 3;

    protected int $qtyPages;
    protected string $pagination;
    protected string $paginationNumbers;

    public function __construct(
        protected string $path,
        protected int $results,
        protected int $currentPage = 1,
        protected int $limit = self::DEFAULT_LISTING_SIZE
    ) {
        $this->currentPage = (is_numeric($currentPage) && $currentPage > 0) ? $currentPage : 1;
        $this->calcQtyPages($results);
    }

    private function calcQtyPages($tableSize): void
    {
        $this->qtyPages = $this->results > 0 ?
            ceil($tableSize / $this->limit) :
            1;

        $this->currentPage = ($this->currentPage <= $this->qtyPages) ?
            $this->currentPage :
            $this->qtyPages;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getResults(): int
    {
        return $this->results;
    }

    public function getCurrentPage(): int
    {
        return $this->currentPage;
    }

    public function getLimit(): string
    {
        $offset = ($this->limit * ($this->getCurrentPage() - 1));
        return "{$offset},{$this->limit}";
    }

    public function getQtyPages(): int
    {
        return $this->qtyPages;
    }

    public function getPaginationHtml(): string
    {
        return View::render(
            'pagination',
            'admin',
            [
                'paginationPreviousDisabled' => ($this->getCurrentPage() <= 1) ? 'disabled' : '',
                'paginationNextDisabled' => ($this->getCurrentPage() >= $this->getQtyPages()) ? 'disabled' : '',
                'pagePrevisous' => ($this->getCurrentPage() > 1) ? ($this->getCurrentPage() - 1) : 1,
                'pageNext' => ($this->getCurrentPage() <= $this->getResults()) ?
                    ($this->getCurrentPage() + 1) :
                    $this->getResults(),
                'path' => $this->getPath(),
                'paginationNumber' => $this->renderPagination()
            ]
        );
    }

    protected function renderPagination(): string
    {
        $this->paginationNumbers = '';

        for ($page = 1; $page <= $this->getQtyPages(); $page++) {
            $this->paginationNumbers .= View::render(
                'paginationNumber',
                'admin',
                [
                    'pageListingPath' => 'roles/listing',
                    'pageId' => $page,
                    'path' => $this->getPath(),
                    'isActive' => $this->getCurrentPage() === $page ? 'active' : ''
                ]
            );
        }

        return $this->paginationNumbers;
    }

    public function isPaginationNeedToBeRendered(): bool
    {
        return $this->getQtyPages() > 1 ? true : false;
    }
}
