<?PHP
namespace TSB\Libs\Worker;

class Child {
 var $myPid;
 var $shm_id;
 var $job;
 var $workerID;

 private $_bufferfifo;
 private $_buffer = array();

 function __construct($workerID) {
  $this->getPid();
  $this->workerID = $workerID;
  $status = cli_set_process_title("TwitchStatsBot: ".$workerID);
  $this->shm_id = shmop_open(0xff3, "c", 0600, 1024);
  printf("[%7s][worker] Spawned worker: %s\n",$this->myPid,$workerID);
  $child_classname = "TSB\Modules\\$workerID";
  $child_obj = new $child_classname(array());
  $this->job = $child_obj;
  $details = $child_obj->moduleInfo();
  printf("[%7s][worker] Worker loading: %s (%s <%s>)\n",$this->myPid,$details["Module"]["Name"],$details["Author"],$details["Email"]);
 }

 function doWork() {
  printf("[%7s][worker] doWork() STARTED\n",$this->myPid);
  //printf("[%7s][worker] doWork(%s): %s\n",$this->myPid,$random_integer,shmop_read($this->shm_id, 0, 1024));
  $job = $this->job;
  //$pipe_path = "/tmp/tsbdata.in";
  $pipe_path = "/tmp/tsb_".$this->workerID.".in";
  posix_mkfifo($pipe_path, 0600);
  $this->_bufferfifo = fopen($pipe_path,'r+');
  stream_set_blocking($this->_bufferfifo, false);
  while (true) {
   $read   = array($this->_bufferfifo);
   $write  = NULL;
   $except = NULL;
   if (stream_select($read,$write,$except,0,15) < 1) {
    $data = $this->bufferRead();
    if ( $data ) $job->run($data);
    usleep(10000);
    continue;
   } else {
    //$dataRead = fgets($this->_bufferfifo,65535);
    $dataRead = stream_get_line($this->_bufferfifo,65535,"\n");
    //$data = fread($this->_bufferfifo,10);
    //printf("[%7s][worker] %s -> fifo data: %s\n",$this->myPid,$this->workerID,$dataRead);
    if (!empty($dataRead)) {
     $status = $this->bufferWrite(trim($dataRead));
    }
   }
   usleep(10000);
  }
  fclose($this->_bufferfifo);
  //printf("[%7s][worker] doWork(%s): %s\n",$this->myPid,$random_integer,shmop_read($this->shm_id, 0, 1024));
  //printf("[%7s][worker] doWork(%s): %s\n",$this->myPid,$random_integer,"Done!");
  printf("[%7s][worker] doWork() ENDED\n",$this->myPid);
  //return true;
 }

 function getPid() {
  $this->myPid = getmypid();
 }


 function bufferEmpty() {
  if (count($this->_buffer)) return false;
  else return true;
 }

 function bufferRead() {
  //printf("[%7s][worker] %s -> bufferRead()\n",$this->myPid,$this->workerID);
  if ( !$this->bufferEmpty() ) {
   $dataArray = array_pop($this->_buffer);
   return $dataArray;
  } else return false;
 }

 function bufferWrite($data) {
  $dataArray = array("timestamp" => time(), "data" => $data);
  $_bufferID = array_unshift($this->_buffer,$dataArray);
  //printf("[%7s][worker] %s -> bufferWrite()\n",$this->myPid,$this->workerID);
  if ($_bufferID) return true;
  else return false;
 }

}
?>
