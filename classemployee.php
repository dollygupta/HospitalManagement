<?php

/**
 * Created by PhpStorm.
 * User: madhav
 * Date: 11/15/15
 * Time: 2:29 AM
 */
class employee
{
    private $EID;
    private $Address;
    private $Name;
    private $Email;
    private $Salary;
    private $type;

    public function gete_id() {return $this->EID; }
    public function getaddress() {return $this->Address; }
    public function gete_name() {return $this->Name; }
    public function getemail() {return $this->Email; }
    public function getsalary() {return $this->Salary; }
    public function gete_type() {return $this->type;}
}
?>