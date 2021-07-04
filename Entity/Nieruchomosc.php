<?php

namespace Entity;

/**
 * Nieruchomosc
 */
class Nieruchomosc
{
    /**
     * @var string
     */
    private $typ_oferty;

    /**
     * @var float
     */
    private $powierzchnia;

    /**
     * @var float
     */
    private $cena;

    /**
     * @var float
     */
    private $cena_m2;

    /**
     * @var int
     */
    private $id;

    /**
     * @var \Entity\Mieszkanie
     */
    private $mieszkanie;

    /**
     * @var \Entity\Miasto
     */
    private $miasto;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $opcjekomunikacji;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->opcjekomunikacji = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set typOferty.
     *
     * @param string $typOferty
     *
     * @return Nieruchomosc
     */
    public function setTypOferty($typOferty)
    {
        $this->typ_oferty = $typOferty;

        return $this;
    }

    /**
     * Get typOferty.
     *
     * @return string
     */
    public function getTypOferty()
    {
        return $this->typ_oferty;
    }

    /**
     * Set powierzchnia.
     *
     * @param float $powierzchnia
     *
     * @return Nieruchomosc
     */
    public function setPowierzchnia($powierzchnia)
    {
        $this->powierzchnia = $powierzchnia;

        return $this;
    }

    /**
     * Get powierzchnia.
     *
     * @return float
     */
    public function getPowierzchnia()
    {
        return $this->powierzchnia;
    }

    /**
     * Set cena.
     *
     * @param float $cena
     *
     * @return Nieruchomosc
     */
    public function setCena($cena)
    {
        $this->cena = $cena;

        return $this;
    }

    /**
     * Get cena.
     *
     * @return float
     */
    public function getCena()
    {
        return $this->cena;
    }

    /**
     * Set cenaM2.
     *
     * @param float $cenaM2
     *
     * @return Nieruchomosc
     */
    public function setCenaM2($cenaM2)
    {
        $this->cena_m2 = $cenaM2;

        return $this;
    }

    /**
     * Get cenaM2.
     *
     * @return float
     */
    public function getCenaM2()
    {
        return $this->cena_m2;
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set mieszkanie.
     *
     * @param \Entity\Mieszkanie|null $mieszkanie
     *
     * @return Nieruchomosc
     */
    public function setMieszkanie(\Entity\Mieszkanie $mieszkanie = null)
    {
        $this->mieszkanie = $mieszkanie;

        return $this;
    }

    /**
     * Get mieszkanie.
     *
     * @return \Entity\Mieszkanie|null
     */
    public function getMieszkanie()
    {
        return $this->mieszkanie;
    }

    /**
     * Set miasto.
     *
     * @param \Entity\Miasto|null $miasto
     *
     * @return Nieruchomosc
     */
    public function setMiasto(\Entity\Miasto $miasto = null)
    {
        $this->miasto = $miasto;

        return $this;
    }

    /**
     * Get miasto.
     *
     * @return \Entity\Miasto|null
     */
    public function getMiasto()
    {
        return $this->miasto;
    }

    /**
     * Add opcjekomunikacji.
     *
     * @param $opcjekomunikacji
     *
     * @return Nieruchomosc
     */
    public function addOpcjekomunikacji($opcjekomunikacji)
    {

        foreach ($opcjekomunikacji as $ok) {
            $this->opcjekomunikacji[] = $ok;
        }

        return $this;
    }

    /**
     * Remove opcjekomunikacji.
     *
     * @param $opcjekomunikacji
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeOpcjekomunikacji($opcjekomunikacji)
    {
        foreach ($opcjekomunikacji as $ok) {
            $this->opcjekomunikacji->removeElement($ok);
        }

        return $this;
    }

    /**
     * Get opcjekomunikacji.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOpcjekomunikacji()
    {
        return $this->opcjekomunikacji;
    }

    //////////////////////////

    public function pobierzKomunikacje()
    {
        $komunikacja = [];

        foreach ($this->getOpcjekomunikacji() as $k) {
            $komunikacja[] = $k->getNazwa();
        }

        return empty($komunikacja) ? '-' : implode(', ', $komunikacja);
    }

    public function pobierzDodatkowe()
    {
        $dodatkowe = [];

        foreach ($this->getDodatkowe() as $d) {
            $dodatkowe[] = $d->getNazwa();
        }

        return empty($dodatkowe) ? '-' : implode(', ', $dodatkowe);
    }
    /**
     * @var \Entity\Dom
     */
    private $dom;

    /**
     * @var \Entity\Grunt
     */
    private $grunt;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $material;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $dodatkowe;


    /**
     * Set dom.
     *
     * @param \Entity\Dom|null $dom
     *
     * @return Nieruchomosc
     */
    public function setDom(\Entity\Dom $dom = null)
    {
        $this->dom = $dom;

        return $this;
    }

    /**
     * Get dom.
     *
     * @return \Entity\Dom|null
     */
    public function getDom()
    {
        return $this->dom;
    }

    /**
     * Set grunt.
     *
     * @param \Entity\Grunt|null $grunt
     *
     * @return Nieruchomosc
     */
    public function setGrunt(\Entity\Grunt $grunt = null)
    {
        $this->grunt = $grunt;

        return $this;
    }

    /**
     * Get grunt.
     *
     * @return \Entity\Grunt|null
     */
    public function getGrunt()
    {
        return $this->grunt;
    }

    /**
     * Add material.
     *
     * @param \Entity\Material $material
     *
     * @return Nieruchomosc
     */
    public function addMaterial(\Entity\Material $material)
    {
        $this->material[] = $material;

        return $this;
    }

    /**
     * Remove material.
     *
     * @param \Entity\Material $material
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeMaterial(\Entity\Material $material)
    {
        return $this->material->removeElement($material);
    }

    /**
     * Get material.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMaterial()
    {
        return $this->material;
    }

    /**
     * Add dodatkowe.
     *
     * @param \Entity\Dodatkowe $dodatkowe
     *
     * @return Nieruchomosc
     */
    public function addDodatkowe(\Entity\Dodatkowe $dodatkowe)
    {
        $this->dodatkowe[] = $dodatkowe;

        return $this;
    }

    /**
     * Remove dodatkowe.
     *
     * @param \Entity\Dodatkowe $dodatkowe
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeDodatkowe(\Entity\Dodatkowe $dodatkowe)
    {
        return $this->dodatkowe->removeElement($dodatkowe);
    }

    /**
     * Get dodatkowe.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDodatkowe()
    {
        return $this->dodatkowe;
    }
}
