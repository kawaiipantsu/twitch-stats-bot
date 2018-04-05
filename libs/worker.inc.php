<?PHP
namespace TSB\Libs\Worker;

class Child {
 var $myPid;
 var $shm_id;
 var $job;

 function __construct($workerID) {
  $this->getPid();
  $status = cli_set_process_title("TwitchStatsBot: ".$workerID);
  $this->shm_id = shmop_open(0xff3, "c", 0600, 1024);
  printf("[%7s][worker] Spawned worker: %s\n",$this->myPid,$workerID);
  $child_classname = "TSB\Modules\\$workerID";
  $child_obj = new $child_classname(array());
  $this->job = $child_obj;
  $details = $child_obj->moduleInfo();
  printf("[%7s][worker] Worker loading: %s (%s <%s>)\n",$this->myPid,$details["Module"]["Name"],$details["Author"],$details["Email"]);
 }

 function doWork($string) {
  $random_integer = rand(60,120);
  printf("[%7s][worker] doWork(%s): %s\n",$this->myPid,$random_integer,$string);
  printf("[%7s][worker] doWork(%s): %s\n",$this->myPid,$random_integer,shmop_read($this->shm_id, 0, 1024));
  $job = $this->job;
  $job->run();
  sleep($random_integer);
  printf("[%7s][worker] doWork(%s): %s\n",$this->myPid,$random_integer,shmop_read($this->shm_id, 0, 1024));
  printf("[%7s][worker] doWork(%s): %s\n",$this->myPid,$random_integer,"Done!");
  return $random_integer;
 }

 function getPid() {
  $this->myPid = getmypid();
 }

}
?>
