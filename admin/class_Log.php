<?php
class Log
{
    public $tekst;
    public function __construct($tekst)
    {
        $this->tekst=$tekst;
    }
    public function upisLogovanje()
    {
        $pom=date("Y.m.d-G.i.s",time())." - ".$this->tekst."\r\n";
        $f=fopen("../admin/log/logovanje.txt", "a");
        fwrite($f, $pom);
        fclose($f);
    }
//    public function upisVesti()
//    {
//        $pom=date("Y.m.d-G.i.s",time())." - ".$this->tekst."\r\n";
//        $f=fopen("admin/log/logVesti.txt", "a");
//        fwrite($f, $pom);
//        fclose($f);
//    }
//    public function izmenaVesti()
//    {
//        $pom=date("Y.m.d-G.i.s",time())." - ".$this->tekst."\r\n";
//        $f=fopen("admin/log/logIzmenaVesti.txt", "a");
//        fwrite($f, $pom);
//        fclose($f);
//    }
}