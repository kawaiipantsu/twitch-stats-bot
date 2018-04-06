<?PHP
namespace TSB\Modules;

use TSB\Libs\Modules\module;

class tsbdb extends module {
 var $author      = "David BL";
 var $description = "TSB-DB worker handles all DB realted";
 var $email       = "@davidbl";

 var $id = "tsbdb";
 var $name = "DB Worker";

 protected $data;

 function __construct($data){
  $this->data = $data;
  printf("[%7s][module] Loaded: %s\n","",get_class($this));
 }

 function run($array) {
  $timestamp = $array["timestamp"];
  $data      = trim($array["data"]);
  printf("[%7s][module] %s -> run() got data! %s(%s)\n","",get_class($this),$timestamp,$data);
 }

}

?>
