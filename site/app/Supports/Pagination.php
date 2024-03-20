<?php

namespace App\Supports;

/**
 *
 */
class Pagination
{
	/**
	 * @var
	 */
	protected $currentPage;
	/**
	 * @var
	 */
	protected $totalPages;
	/**
	 * @var int|mixed
	 */
	protected $range;

	/**
	 * @param $currentPage
	 * @param $totalPages
	 * @param $range
	 */
	public function __construct($currentPage, $totalPages, $range = 2)
	{
		$this->currentPage = $currentPage;
		$this->totalPages = $totalPages;
		$this->range = $range;
	}

	/**
	 * @return string
	 */
    public function getLinks()
    {
        $firstPage = 1;
        $lastPage = $this->totalPages;

        // Obtém os parâmetros da URL atual
        $currentParams = $_GET;
        unset($currentParams['route']);

        $paginate = "
        <nav aria-label='Page navigation'>
            <ul class='pagination m-0 p-0'>";

        // Adiciona os parâmetros atuais à URL da página inicial
        if ($this->currentPage > $this->range + 1) {
            $currentParams['page'] = $firstPage;
            $firstPageUrl = http_build_query($currentParams);
            $paginate .= "<li class='page-item'><a class='page-link' href='?$firstPageUrl'>Primeira</a></li>";
        }

        // Adiciona os parâmetros atuais à URL da página anterior
        if ($this->currentPage > 1) {
            $currentParams['page'] = $this->currentPage - 1;
            $prevPageUrl = http_build_query($currentParams);
            $paginate .= "<li class='page-item'><a class='page-link' href='?$prevPageUrl'>Anterior</a></li>";
        }

        for ($i = max($firstPage, $this->currentPage - $this->range); $i <= min($lastPage, $this->currentPage + $this->range); $i++) {
            // Adiciona os parâmetros atuais à URL da página atual
            $currentParams['page'] = $i;
            $currentPageUrl = http_build_query($currentParams);

            if ($i === $this->currentPage) {
                $paginate .= "<li class='page-item active'><a class='page-link' href='?$currentPageUrl'>$i</a></li>";
            } else {
                $paginate .= "<li class='page-item'><a class='page-link' href='?$currentPageUrl'>$i</a></li>";
            }
        }

        // Adiciona os parâmetros atuais à URL da próxima página
        if ($this->currentPage < $this->totalPages) {
            $currentParams['page'] = $this->currentPage + 1;
            $nextPageUrl = http_build_query($currentParams);
            $paginate .= "<li class='page-item'><a class='page-link' href='?$nextPageUrl'>Próxima</a></li>";
        }

        // Adiciona os parâmetros atuais à URL da última página
        if ($this->currentPage < $this->totalPages - $this->range) {
            $currentParams['page'] = $lastPage;
            $lastPageUrl = http_build_query($currentParams);
            $paginate .= "<li class='page-item'><a class='page-link' href='?$lastPageUrl'>Última</a></li>";
        }

        $paginate .= "</ul>
        </nav>";

        if ($this->totalPages > 1) {
            return $paginate;
        } else {
            return '';
        }
    }

}
