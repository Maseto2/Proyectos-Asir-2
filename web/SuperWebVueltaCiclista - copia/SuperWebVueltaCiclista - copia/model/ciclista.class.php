<?php
class Ciclista {
    private $id;
    private $nombre;
    private $apellido;
    private $usuario;
    private $contra;
    private $mail;
    private $idequipo;
    private $idrol;

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
     * Get the value of nombre
     */ 
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set the value of nombre
     *
     * @return  self
     */ 
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get the value of apellido
     */ 
    public function getApellido()
    {
        return $this->apellido;
    }

    /**
     * Set the value of apellido
     *
     * @return  self
     */ 
    public function setApellido($apellido)
    {
        $this->apellido = $apellido;

        return $this;
    }

    /**
     * Get the value of usuario
     */ 
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * Set the value of usuario
     *
     * @return  self
     */ 
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get the value of contra
     */ 
    public function getContra()
    {
        return $this->contra;
    }

    /**
     * Set the value of contra
     *
     * @return  self
     */ 
    public function setContra($contra)
    {
        $this->contra = $contra;

        return $this;
    }

    /**
     * Get the value of mail
     */ 
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * Set the value of mail
     *
     * @return  self
     */ 
    public function setMail($mail)
    {
        $this->mail = $mail;

        return $this;
    }



    /**
     * Get the value of idequipo
     */ 
    public function getIdequipo()
    {
        return $this->idequipo;
    }

    /**
     * Set the value of idequipo
     *
     * @return  self
     */ 
    public function setIdequipo($idequipo)
    {
        $this->idequipo = $idequipo;

        return $this;
    }

    /**
     * Get the value of idrol
     */ 
    public function getIdrol()
    {
        return $this->idrol;
    }

    /**
     * Set the value of idrol
     *
     * @return  self
     */ 
    public function setIdrol($idrol)
    {
        $this->idrol = $idrol;

        return $this;
    }
}

?>