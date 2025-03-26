<?php
class Examen {
    private $id;
    private $asignatura;
    private $enunciado1;
    private $puntuacion1;
    private $enunciado2;
    private $puntuacion2;
    private $aprobado;

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
     * Get the value of asignatura
     */ 
    public function getAsignatura()
    {
        return $this->asignatura;
    }

    /**
     * Set the value of asignatura
     *
     * @return  self
     */ 
    public function setAsignatura($asignatura)
    {
        $this->asignatura = $asignatura;

        return $this;
    }

    /**
     * Get the value of enunciado1
     */ 
    public function getEnunciado1()
    {
        return $this->enunciado1;
    }

    /**
     * Set the value of enunciado1
     *
     * @return  self
     */ 
    public function setEnunciado1($enunciado1)
    {
        $this->enunciado1 = $enunciado1;

        return $this;
    }

    /**
     * Get the value of puntuacion1
     */ 
    public function getPuntuacion1()
    {
        return $this->puntuacion1;
    }

    /**
     * Set the value of puntuacion1
     *
     * @return  self
     */ 
    public function setPuntuacion1($puntuacion1)
    {
        $this->puntuacion1 = $puntuacion1;

        return $this;
    }

    /**
     * Get the value of enunciado2
     */ 
    public function getEnunciado2()
    {
        return $this->enunciado2;
    }

    /**
     * Set the value of enunciado2
     *
     * @return  self
     */ 
    public function setEnunciado2($enunciado2)
    {
        $this->enunciado2 = $enunciado2;

        return $this;
    }

    /**
     * Get the value of puntuacion2
     */ 
    public function getPuntuacion2()
    {
        return $this->puntuacion2;
    }

    /**
     * Set the value of puntuacion2
     *
     * @return  self
     */ 
    public function setPuntuacion2($puntuacion2)
    {
        $this->puntuacion2 = $puntuacion2;

        return $this;
    }

    /**
     * Get the value of aprobado
     */ 
    public function getAprobado()
    {
        return $this->aprobado;
    }

    /**
     * Set the value of aprobado
     *
     * @return  self
     */ 
    public function setAprobado($aprobado)
    {
        $this->aprobado = $aprobado;

        return $this;
    }
}
?>