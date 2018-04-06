<?PHP
namespace TSB\Modules;

use TSB\Libs\Modules\module;

class template extends module {
 var $author      = "Template Author";
 var $description = "This is just a Template";
 var $email       = "template@template.com";

 var $id     = "template";
 var $name   = "Template Worker";

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
