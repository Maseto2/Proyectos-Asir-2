<?php
class Vuelta {
    private $id;
    private $idciclista;
    private $tiempo;
    private $fecha;
    private $numVuelta;

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of idciclista
     */ 
    public function getIdciclista()
    {
        return $this->idciclista;
    }

    /**
     * Set the value of idciclista
     *
     * @return  self
     */ 
    public function setIdciclista($idciclista)
    {
        $this->idciclista = $idciclista;

        return $this;
    }

    /**
     * Get the value of tiempo
     */ 
    public function getTiempo()
    {
        return $this->tiempo;
    }

    /**
     * Set the value of tiempo
     *
     * @return  self
     */ 
    public function setTiempo($tiempo)
    {
        $this->tiempo = $tiempo;

        return $this;
    }

    /**
     * Get the value of fecha
     */ 
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set the value of fecha
     *
     * @return  self
     */ 
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get the value of numVuelta
     */ 
    public function getNumVuelta()
    {
        return $this->numVuelta;
    }

    /**
     * Set the value of numVuelta
     *
     * @return  self
     */ 
    public function setNumVuelta($numVuelta)
    {
        $this->numVuelta = $numVuelta;

        return $this;
    }
}