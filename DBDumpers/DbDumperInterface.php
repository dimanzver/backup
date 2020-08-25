<?php


namespace app\DBDumpers;


interface DbDumperInterface
{

    public function dump();

    public function restore();

}