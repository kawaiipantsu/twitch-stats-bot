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

 function run() {
  printf("[%7s][module] %s :: run()\n","",get_class($this));
 }

}

?>
