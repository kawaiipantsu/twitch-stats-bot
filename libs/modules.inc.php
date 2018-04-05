<?PHP

namespace TSB\Libs\Modules;

class module {
 function moduleInfo() {
  $moduleinfo = array(
   "Module"      => array(
    "ID"         => $this->id,
    "Name"       => $this->name,
   ),
   "Author"      => $this->author,
   "Email"       => $this->email,
   "Description" => $this->description
  );
  return $moduleinfo;
 }
}

?>
