<?php
class Liquidacion{
    /*
    id int not null auto_increment primary key,
    folio int not null,
    contrato int not null references contratos(id),
    periodo date not null,
    empresa int not null references empresa(id),
    trabajador int not null references trabajadores(id),
    diastrabajados int not null,
    sueldobase int not null,
    horasfalladas int not null,
    horasextras1 int not null,
    horasextras2 int not null,
    horasextras3 int not null,
    afp varchar(200) not null,
    porafp varchar(200) not null,
    salud varchar(200) not null,
    porsalud varchar(200) not null,    
    totalimponible int not null,
    totalnoimponible int not null,
    totaltributable int not null,
    totaldeslegales int not null,
    totaldesnolegales int not null,
    fecha_liquidacion date not null,
    register_at timestamp not null default current_timestamp*/

    private $id;
    private $folio;
    private $contrato;
    private $periodo;
    private $empresa;
    private $trabajador;
    private $diastrabajados;
    private $sueldobase;
    private $horasfalladas;
    private $horasextras1;
    private $horasextras2;
    private $horasextras3;
    private $afp;
    private $porafp;
    private $salud;
    private $porsalud;
    private $totalimponible;
    private $totalnoimponible;
    private $totaltributable;
    private $totaldeslegales;
    private $totaldesnolegales;
    private $fecha_liquidacion;
    private $register_at;

    public function __construct($id, $folio, $contrato, $periodo, $empresa, $trabajador, $diastrabajados, $sueldobase, $horasfalladas, $horasextras1, $horasextras2, $horasextras3, $afp, $porafp, $salud, $porsalud, $totalimponible, $totalnoimponible, $totaltributable, $totaldeslegales, $totaldesnolegales, $fecha_liquidacion, $register_at){
        $this->id = $id;
        $this->folio = $folio;
        $this->contrato = $contrato;
        $this->periodo = $periodo;
        $this->empresa = $empresa;
        $this->trabajador = $trabajador;
        $this->diastrabajados = $diastrabajados;
        $this->sueldobase = $sueldobase;
        $this->horasfalladas = $horasfalladas;
        $this->horasextras1 = $horasextras1;
        $this->horasextras2 = $horasextras2;
        $this->horasextras3 = $horasextras3;
        $this->afp = $afp;
        $this->porafp = $porafp;
        $this->salud = $salud;
        $this->porsalud = $porsalud;
        $this->totalimponible = $totalimponible;
        $this->totalnoimponible = $totalnoimponible;
        $this->totaltributable = $totaltributable;
        $this->totaldeslegales = $totaldeslegales;
        $this->totaldesnolegales = $totaldesnolegales;
        $this->fecha_liquidacion = $fecha_liquidacion;
        $this->register_at = $register_at;
    }

    public function getId(){
        return $this->id;
    }

    public function getFolio(){
        return $this->folio;
    }

    public function getContrato(){
        return $this->contrato;
    }

    public function getPeriodo(){
        return $this->periodo;
    }

    public function getEmpresa(){
        return $this->empresa;
    }

    public function getTrabajador(){
        return $this->trabajador;
    }

    public function getDiastrabajados(){
        return $this->diastrabajados;
    }

    public function getSueldobase(){
        return $this->sueldobase;
    }

    public function getHorasfalladas(){
        return $this->horasfalladas;
    }

    public function getHorasextras1(){
        return $this->horasextras1;
    }

    public function getHorasextras2(){
        return $this->horasextras2;
    }

    public function getHorasextras3(){
        return $this->horasextras3;
    }

    public function getAfp(){
        return $this->afp;
    }

    public function getPorafp(){
        return $this->porafp;
    }

    public function getSalud(){
        return $this->salud;
    }

    public function getPorsalud(){
        return $this->porsalud;
    }

    public function getTotalimponible(){
        return $this->totalimponible;
    }

    public function getTotalnoimponible(){
        return $this->totalnoimponible;
    }

    public function getTotaltributable(){
        return $this->totaltributable;
    }

    public function getTotaldeslegales(){
        return $this->totaldeslegales;
    }

    public function getTotaldesnolegales(){
        return $this->totaldesnolegales;
    }

    public function getFecha_liquidacion(){
        return $this->fecha_liquidacion;
    }

    public function getRegister_at(){
        return $this->register_at;
    }
}