<?php

namespace Model;

use \Doctrine\ORM\Query;
use Doctrine\ORM\Tools\Pagination\Paginator;

class Stronicowanie
{
	private Query $query;
	
	private int $strona;

	private int $limit;
	
	public function __construct(Query $query, int $strona, int $limit)
	{
		$this->query = $query;
		$this->strona = $strona;
		$this->limit = $limit;
		
		$this->query->setFirstResult($strona * $limit);
		$this->query->setMaxResults($limit);
	}

    /**
     * Zwraca rekordy dla danej podstrony.
     *
     * @return array
     */
	public function pobierzDane(): array
    {
		return $this->query->execute();
	}
	
	/**
	 * Zwraca HTML z linkami do wszystkich podstron.
	 * 
	 * @return string
	 */
	public function pobierzLinki(): string
    {
		$paginator = new Paginator($this->query);
		$liczbaRekordow = $paginator->count();
		$liczbaStron = ceil($liczbaRekordow / $this->limit);
		$nazwaPliku = $_SERVER['SCRIPT_NAME'];
		
		// czyszczenie parametrow z linka
		$parametry = array();
		foreach($_GET as $kl => $wart) {
			if (!in_array($kl, ['szukaj', 'strona'])) {
				$parametry[] = "$kl=$wart";
			}
		}
		
		// stworzenie poczatku query stringa
		$qs = implode('&', $parametry);
		
		// generowanie linkow do podstron
		$html = '<nav aria-label="Page navigation example"><ul class="pagination">';

		for($i = 0; $i < $liczbaStron; $i++) {
			if($i == $this->strona) {
				$html .= '<li class="page-item active" aria-current="page"><a class="page-link" href="#">' .
                    ($i + 1) .
                    ' <span class="sr-only">(current)</span></a></li>';

			} else {
			    $html .= sprintf(
			        '<li class="page-item"><a class="page-link" href="%s?%s&strona=%d">%d</a></li>',
                    $nazwaPliku,
                    $qs,
                    $i,
                    $i + 1
                );
			}
		}

		$html .= '</ul></nav>';

		if($liczbaStron > 1) {
            $html .= "<ul class='pagination'>";
            //Link do pierwszej podstrony
            if ($this->strona == 0) {
                $html .= sprintf("<li class='page-item active'><a class='page-link'>%s</a></li>", "Początek");
            } else {
                $html .= sprintf(
                    "<li class='page-item'><a href='%s?%s&strona=%d' class='page-link'>%s</a></li>",
                    $nazwaPliku,
                    $qs,
                    0,
                    "Początek"
                );
            }


            //Link do strony poprzedniej
            if ($this->strona == 0) {
                $html .= sprintf("<li class='page-item disabled'><a class='page-link'>%s</a></li>", "Poprzednia");
            } else {
                $html .= sprintf(
                    "<li class='page-item'><a href='%s?%s&strona=%d' class='page-link'>%s</a></li>",
                    $nazwaPliku,
                    $qs,
                    $this->strona - 1,
                    "Poprzednia"
                );
            }

            //Link do strony nastepnej
            if ($this->strona == $liczbaStron - 1) {
                $html .= sprintf("<li class='page-item disabled'><a class='page-link'>%s</a></li>", "Następna");
            } else {
                $html .= sprintf(
                    "<li class='page-item'><a href='%s?%s&strona=%d' class='page-link'>%s</a></li>",
                    $nazwaPliku,
                    $qs,
                    $this->strona + 1,
                    "Następna"
                );
            }

            //Link do ostatniej strony
            if ($this->strona == $liczbaStron - 1) {
                $html .= sprintf("<li class='page-item active'><a class='page-link'>%s</a></li>", "Koniec");
            } else {
                $html .= sprintf(
                    "<li class='page-item'><a href='%s?%s&strona=%d' class='page-link'>%s</a></li>",
                    $nazwaPliku,
                    $qs,
                    $liczbaStron - 1,
                    "Koniec"
                );
            }
            $html .= "</ul>";
        }

            //Dodanie informacji o liczbie wybranych rekordow i obecnie wyswietlanych
            $html .= "</ul></nav>";
            $html .= "<p align='left'>Wyświetlono rekordy ";
            if ($liczbaRekordow > 0){
                $html .= sprintf($this->strona * $this->limit + 1);
                $html .= " - ";
                //Jeżeli jest wyświetlona ostatnia strona
                if ($this->strona == $liczbaStron - 1) {
                    $html .= sprintf($liczbaRekordow);
                } //Jeżeli jest wyświetlona inna niż ostatnia strona
                else {
                    $html .= sprintf($this->strona * $this->limit + $this->limit);
                }
                $html .= " z ";
            }
            $html .= sprintf($liczbaRekordow);
            $html .= "</p>";
		return $html;
    }
}