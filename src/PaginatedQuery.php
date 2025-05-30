<?php
namespace App;

use Exception;
use PDO;

class PaginatedQuery
{
    private $query;
    private $queryCount;
    private $pdo;
    private $perPage;
    private $count;
    private $items;

    public function __construct(
        string $query,
        string $queryCount,
        ?\PDO $pdo = null,
        int $perPage = 12
    ) {
        $this->query = $query;
        $this->queryCount = $queryCount;
        $this->pdo = $pdo ?: Connection::getPDO();
        $this->perPage = $perPage;
    }

    public function getItems(string $classMapping): array
    {
        if ($this->items === null) {
            $currentPage = $this->getCurrentPage();
            $pages = $this->getPages();
            if ($currentPage > $pages) {
                throw new Exception("Cette page n'existe pas");
            }
            $offset = ($currentPage - 1) * $this->perPage;
            $this->items = $this->pdo->query(
                $this->query .
                " LIMIT {$this->perPage} OFFSET $offset"
            )->fetchAll(PDO::FETCH_CLASS, $classMapping);
        }
        return $this->items;
    }

    private function getCurrentPage(): int
    {
        return URL::getPositiveInt('page', 1);
    }

    private function getPages(): int
    {
        if ($this->count === null) {
            $result = $this->pdo->query($this->queryCount)->fetch(PDO::FETCH_NUM);
            $this->count = ($result !== false) ? (int)$result[0] : 0;
        }
        return max(1, ceil($this->count / $this->perPage));
    }

    public function previousLink($link): ?string
    {
        $currentPage = $this->getCurrentPage();
        if ($currentPage === 1) return null;
        if ($currentPage > 2) $link .= "?page=" . ($currentPage - 1);
        $escapedLink = htmlspecialchars($link, ENT_QUOTES, 'UTF-8');
        return <<<HTML
            <a href="{$escapedLink}" class="btn btn-primary">&laquo; Page précédente</a>
HTML;
    }

    public function nextLink($link): ?string
    {
        $currentPage = $this->getCurrentPage();
        $pages = $this->getPages();
        if ($currentPage >= $pages) return null;
        $link .= "?page=" . ($currentPage + 1);
        $escapedLink = htmlspecialchars($link, ENT_QUOTES, 'UTF-8');
        return <<<HTML
            <a href="{$escapedLink}" class="btn btn-primary ml-auto">Page suivante &raquo;</a>
HTML;
    }
}