<?PHP
namespace TSB\Libs\Daemon;

require_once("modules.inc.php");
require_once("worker.inc.php");
require_once("tsbdb.inc.php");
require_once("tsbirc.inc.php");

use TSB\Libs\Worker\Child;


class TwitchStatsBot {
 var $myPid;
 var $shm_id;
 var $children = array();
 var $predefinedWorkers = array("tsbdb","tsbirc");
 var $moduleWorkers = array();

 function __construct() {
  declare(ticks=1);
  $this->updatePid();
  $status = cli_set_process_title("TwitchStatsBot");
  $this->enableSignalHandlers();
  $this->shm_id = shmop_open(0xff3, "c", 0600, 1024);
 }

 function enableSignalHandlers() {
  printf("[%7s][daemon] enableSignalHandlers()\n",$this->myPid);
  pcntl_signal(SIGINT,  array($this, 'signalHandler'));
  pcntl_signal(SIGTERM, array($this, 'signalHandler'));
  pcntl_signal(SIGHUP,  array($this, 'signalHandler'));
  pcntl_signal(SIGUSR1, array($this, 'signalHandler'));
  pcntl_signal(SIGUSR2, array($this, 'signalHandler'));
  pcntl_signal(SIGCHLD, array($this, 'signalHandler'));
  pcntl_signal(SIGALRM, array($this, 'signalHandler'));
 }

 function initialize () {
  $shm_size = shmop_size($this->shm_id);
  printf("[%7s][daemon] Initializing\n",$this->myPid);
  printf("[%7s][daemon] Reading data modules\n",$this->myPid);
  $this->prepareModules();
  printf("[%7s][daemon] Shared memory created: %s\n",$this->myPid,$shm_size);
 }

 function prepareModules() {
  $modules = array();
  if ($handle = opendir('data-modules')) {
    while (false !== ($entry = readdir($handle))) {
        if ($entry != "." && $entry != ".." && preg_match("/\.module\.php/",$entry) ) {
         require("data-modules/".$entry);
         $modulename = basename($entry,".module.php");
         $modules[] = $modulename;
        }
    }
    closedir($handle);
  }
  $this->moduleWorkers = $modules;
 }

 function doSpawn() {
  printf("[%7s][daemon] Spawning workers\n",$this->myPid);
  $allWorkers = array_merge($this->predefinedWorkers,$this->moduleWorkers);
  foreach ($allWorkers as $workerID) {
   if( ( $pid = pcntl_fork() ) == 0) {
    $child = new Child($workerID);
    $returnCode = $child->doWork(date("r"));
    exit($returnCode);
   } else {
    $this->children[] = $pid;
   }
  }
  $numChilds = count($this->children);
  printf("[%7s][daemon] Spawned %s child(s)\n",$this->myPid,$numChilds);
 }

 function signalHandler($signo) {
  switch ($signo) {
   case SIGTERM:
    $this->exitDaemon();
    exit();
    break;

   case SIGINT:
    $this->exitDaemon();
    exit();
    break;

   case SIGCHLD:
    pcntl_signal(SIGCHLD, array($this,"signalHandler"));
    while(($pid = pcntl_wait($status, WNOHANG)) > 0) {
    $this->children = array_diff($this->children, array($pid));
    $numChilds = count($this->children);
    if(!pcntl_wifexited($status)) {
     printf("[%7s][daemon] Child[%s] killed (Children left: %s)\n",$this->myPid,$pid,$numChilds);
    } else {
     printf("[%7s][daemon] Child[%s] exited (Children left: %s)\n",$this->myPid,$pid,$numChilds);
    }
   }
   break;

   default:
    printf("[%7s][daemon] SignalHandler, unknown signal: %s\n",$this->myPid,$signo);
    break;
  }
 }

 function simulateWork() {
  sleep(rand(1,6));
  $shm_bytes_written = shmop_write($this->shm_id, time(), 0);
  printf("[%7s][daemon] Simulating parent work ...\n",$this->myPid);
 }

 function doWait() {
  while($this->children) {
   $this->simulateWork();
  }
  pcntl_alarm(0);
 }

 function updatePid() {
  $this->myPid = getmypid();
 }

 static public function getPid() {
  return $this->myPid;
 }

 function exitDaemon() {
  shmop_delete($this->shm_id);
  shmop_close($this->shm_id);
  foreach ($this->children as $childpid) {
   posix_kill($childpid,SIGKILL);
  }
 }

}

?>
