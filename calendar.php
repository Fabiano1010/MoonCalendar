<?php
class Calendar
{
    private int $r;
    private int $c;
    private int $var;

    public function __construct($r=6, $c = 7, $var=0)
    {
        $this->r = $r;
        $this->c = $c;
        $this->var = $var;     
    }
    public function getRows()
    {
        return $this->r;
    }
    public function getColumns()
    {
        return $this->c;
    }
    public function getVar(){
        return $this->var;
    }
    public function setVar($var){
        return $this->var=$var;
    }

    public function setRows($r)
    {
        return $this->r = $r;
    }
    public function setColumns($c)
    {
        return $this->c = $c;
    }

    private function today(){
        $today = date('Y-n-j', time());

        return $today;
    }
    private function month($var){
        $dif = $var * 2628000;
        $month = date("n", time()+$dif);
        $year = date("Y", time()+$dif);
        return $year."-".$month;
    }
    private function newmoon(){
        $newmoon_array = array();
//        nów początkowy
        $newmoon = strtotime("1970-01-07 21:35:40");

        array_push($newmoon_array, $newmoon);

        for($i=0; $i<=5000; $i++) {
            $newmoon = $newmoon+2551443;//2505600+43200+2640+3=2551443
            array_push($newmoon_array, $newmoon);
        }
        $newmoon_array_date = array();
        foreach ($newmoon_array as $value) {
            array_push($newmoon_array_date, date('Y-n-j', $value));
        }
        return $newmoon_array_date;
            
    }
    public function fullmoon(){
        $fullmoon_array = array();
//        pełnia początkowa
        $fullmoon = strtotime("1970-01-22 13:55:25");

        array_push($fullmoon_array, $fullmoon);

        for($i=0; $i<=5000; $i++) {
            $fullmoon = $fullmoon+2551443;//2505600+43200+2640+3=2551443
            array_push($fullmoon_array, $fullmoon);
        }

        $fullmoon_array_date = array();
        foreach ($fullmoon_array as $value) {
            
            array_push($fullmoon_array_date, date('Y-n-j', $value));
        }
        return $fullmoon_array_date;
        
}

   private function daysInMonth($y, $m){
    $d = 1;
    $time = strtotime($y.'-'.$m.'-'.$d);
    $totalDays = date('t',$time);
    return $totalDays;
   }

    private function firstDayMonth($y, $m){
        $d = 1;
        $time = strtotime($y.'-'.$m.'-'.$d);
        $dayOfMonth = date('w',$time);
        return $dayOfMonth;
    }
    
    private function table($var)
    {
       
        // strefa czasowa
        date_default_timezone_set('Europe/Warsaw');
        // ten rok i miesiac, ten rok, ten miesiac, teraz
        $n = $this->month($var);
        $n = explode("-",$n);

        $m=$n[1];
        $y=$n[0];
        // echo $y."-".$m."<br>";
        $ym = date('Y m', time());
        
        $timestamp = strtotime($ym,"-01");
        if($timestamp===false){
            $timestamp=time();
        }
        // ile dni w tym miesiącu
        $day_count = $this->daysInMonth($y, $m);
        //jaki jest pierwszy dzien tego miesiaca:0-niedziela, 1-poniedziałek 2-wtorek 3-środa 4-czwartek 5-piatek 6-sobota
        $d = $this->firstDayMonth($y, $m);

        // RYSOWANIE TABELI
        // nagłowek tabeli
        $t = "<div class='board2'><div class='days-head'>";
        $headers = "";
        $days = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
        for ($i = 0; $i < $this->c; $i++) {
            $headers .= "<div class='days-headers'><h3>$days[$i]</h3></div>";
        }
        $t .= $headers;
        $t .= "</div>";

        //ciało tabeli
        $parts = "";
        $l = 0; //liczba porządkowa do liczby komórek
        $o = 0; // liczba do numerowania dni miesiaca
        
        for ($z = 0; $z < $this->r; $z++) { // drukowanie tabeli - wiersze
            $parts .= "<div class='days-body'>"; // wiersze tabeli - tyle ile tygodni
            for ($j = 0; $j < $this->c; $j++) {// drukowanie tabeli - komórki
            $l += 1;
            
                if($l>$d){ //jeśli liczba porządkowa jest większa od numeru dnia tygodnia pierwszego miesiąca to drukuj dni miesiaca
                    $o+=1;
                        if ($o <= $day_count){ 
                            $currrentym=$this->month($var);//miesiac i rok teraz
                            
                            if($this->today()==$currrentym."-".$o){ // sprawdzanie który dzień jest dziś            
                                $parts .= "<div class='today' id='".$currrentym."-".$o."'.>";
                                $parts .= "<h4>" ."$o". "</h4>";
                                $newmoon=$this->newmoon();
                                $fullmoon=$this->fullmoon();
                                $x=$currrentym."-".$o;
                                if(in_array($x, $newmoon)){
                                    $parts.="<div class='moon'>
                                    <div class='disc'></div>
                                    </div>";
                                }
                                else if(in_array($x, $fullmoon)){
                                    $parts.="<div class='moon2'>
                                    <div class='disc2'></div>
                                    </div>";
                                }
                                $parts .= "</div>";
                            }
                            else{ // drukuj dni
                                $parts .= "<div class='days' id='".$currrentym."-".$o."'.>";
                                $parts .= "<h4>" ."$o". "</h4>";
                                $newmoon=$this->newmoon();
                                $fullmoon=$this->fullmoon();
                                $x=$currrentym."-".$o;
                                if(in_array($x, $newmoon)){
                                    $parts.="<div class='moon'>
                                    <div class='disc'></div>
                                    </div>";
                                }
                                else if(in_array($x, $fullmoon)){
                                    $parts.="<div class='moon2'>
                                    <div class='disc2'></div>
                                    </div>";
                                }
                                $parts .= "</div>";

        
                            }
                        }
                        else{ //jesli inaczej drukuj puste (na końcu)

                            $parts .= "<div class='days-none'>";
                            $parts .= "<h4>" ."&nbsp". "</h4>";
                            $parts .= "</div>";
                        }
                    }
                    else{//jesli inaczej drukuj puste (na początku)
                            $parts .= "<div class='days-none'>";
                            $parts .= "<h4>" ."&nbsp". "</h4>";
                            $parts .= "</div>";
                    }
                }
            $parts .= "</div>";
        }
        $t .= $parts;
        $t .= "</div></div>";
        
        return $t;
    }
    public function print_table($var)
    {
        
        return $this->table($var);

    }
    private function ym($m,$var){
        date_default_timezone_set('Europe/Warsaw');
        $n = $this->month($var); 
        $n = explode("-",$n);
        $months=['1'=>'Styczeń', '2'=>'Luty', '3'=>'Marzec','4'=>'Kwiecień','5'=>'Maj','6'=>'Czerwiec','7'=>'Lipiec','8'=>'Sierpierń','9'=>'Wrzesień','10'=>'Październik','11'=>'Listopad','12'=>'Grudzień'];
        $m=$months[$n[1]];
        return $m." ".$n[0];
    }
    public function YearMonth($m, $var){
        return $this->ym($m, $var);
    }
}
