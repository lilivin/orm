<?php

namespace Entity;

/**
 * Miasto
 */
class Miasto
{
    /**
     * @var string
     */
    private $nazwa;

    /**
     * @var int
     */
    private $id;

    /**
     * @var \Entity\Powiat
     */
    private $powiat;


    /**
     * Set nazwa.
     *
     * @param string $nazwa
     *
     * @return Miasto
     */
    public function setNazwa($nazwa)
    {
        $this->nazwa = $nazwa;

        return $this;
    }

    /**
     * Get nazwa.
     *
     * @return string
     */
    public function getNazwa()
    {
        return $this->nazwa;
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
     * Set powiat.
     *
     * @param \Entity\Powiat|null $powiat
     *
     * @return Miasto
     */
    public function setPowiat(\Entity\Powiat $powiat = null)
    {
        $this->powiat = $powiat;

        return $this;
    }

    /**
     * Get powiat.
     *
     * @return \Entity\Powiat|null
     */
    public function getPowiat()
    {
        return $this->powiat;
    }
}
