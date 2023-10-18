<?php
function processSketchFiles()
{
    /*
      Justin puts skectches in G:\pa_photos\Sketches folder (mnt/paphotos/Sketches)
      create record in Vision
      rename and move jpeg
      log file
      error email
      when finished = delete images from /mnt/paphotos/Sketches
     */
    $baseinclude = "/var/www/html/common";
    if (is_dir($baseinclude)) {
        require_once "$baseinclude/PutnamBaseInclude/putDBcontrol.php";
        require_once "$baseinclude/functions/Debug.php";
        $debugfile = "/var/tmp/convertVisionSketch.out";
        $debuglevel = 9;
        $debugfsize = 2000000;
        $mypid = posix_getpid();
    } else {
        print "Error in configuration - no baseinclude defined\n";
        exit(-1);
    }
    //chmod("/var/tmp/convertVisionSketch.out", 0777);
    $dbStateVision = "production";
    $dbNameVision = "V7_VISION";
    $vDb = new putDBcontrol();
    $vDb->dbState = $dbStateVision;
    $vDb->dbName = $dbNameVision;
    $errmsg = "Open db $vDb->dbName";
    Debug(9, $errmsg);
    if ($vDb->putDBopen()) {
        $errmsg = "database " . $vDb->dbName . " is open<br>";
        Debug(9, $errmsg);
    } else {
        print "Database open failed for $dbNameVision";
        Debug(9, $vDb->dbErrorMessage);
        exit(0);
    }

    $testing = TRUE;
    $checkDupes = TRUE;
    $imageArr = array();
    //$myDir = "tmp";
    $myDir = "/mnt/paphotos/Sketches"; // if running from here - dont delete?   ???
    $myImages = scandir($myDir);
    //echo "<p>images = <pre>";
    print_r($myImages);
    //echo "</pre>";
    foreach ($myImages as $key => $value) {
        if ($value == "." || $value == ".." || $value == "savedInVision") {
            unset($myImages[$key]);
        }
    }
    //echo "<p>image count = ".count($myImages);
    $totalCount = count($myImages);
    $dupeCount = 0;
    $processedCount = 0;
    foreach ($myImages as $image) {
        list($pid, $bid) = explode("_", $image);
        //echo "<hr><p>image = $image<br>pid = $pid - bid = $bid";
        Debug(1, "\n\nWORKING $pid / $bid / $image");
        if (isset($pid) && $pid > 0) {
            $bid = substr($bid, 0, -4); // ditch .jpg at end
            $dupe = FALSE;
            if ($checkDupes == TRUE) {
                $fileDate = date("Y-m-d", filemtime("$myDir/$image"));
                $dupe = checkForDupe($pid, $bid, $fileDate);
                //echo "<p>dupe count = $dupe";
                if (isset($dupe) && $dupe > 0) {
                    //echo "<br>DUPE!<br>";
                    $dupe = TRUE;
                    $dupeCount++;
                    $destFile = "/var/www/html/pa/photo_uploader/convertVisionSketch/dupes/$image";
                    $originFile = "/var/www/html/pa/photo_uploader/convertVisionSketch/tmp/$image";
                    //echo "<p>origin = $originFile";
                    //echo "<br>dupeDir = $destFile";
                    // PUT THIS BACK IN ????
                    //if (FALSE == copy($originFile, $destFile)) {
                    //    //echo "<p>did not copy dupe";
                    //} else{
                    //    unlink($originFile);
                    //}
                } else {
                    //echo "<br>no dupe<br>";
                }
            }
            if ($dupe == FALSE) {
                $processedCount++;
                $pn = pullPN($pid);
                //echo "<br>pn = $pn";
                // need error and a break if no pn is found ???
                $p = explode("-", $pn);
                $trs = $p[1] . $p[2] . $p[0];
                $rimId = insertCommonRecord($trs, $pn);
                //echo "<br>after function";
                //echo "<br>RIM ID = $rimId";
                if (isset($rimId) && $rimId > 0) {
                    $idStr = str_pad($rimId, 8, "0", STR_PAD_LEFT);
                    $fileName = $pn . "." . $idStr;
                    //echo "<br>filename = $fileName";
                    $fileDate = date("Y-m-d", filemtime("tmp/$image"));
                    //echo "<br>fileDate = $fileDate";
                    insertRealPropRecord(
                        $pid,
                        $bid,
                        $rimId,
                        $fileName,
                        $fileDate
                    );
                    // rename file and move
                    if ($testing == TRUE) {
                        $destDir = "/var/www/html/pa/photo_uploader/convertVisionSketch/test/$trs";
                        $destFile = "$destDir/$pn.$idStr.jpg";
                        $originFile = "/var/www/html/pa/photo_uploader/convertVisionSketch/tmp/$image";
                        //echo "<p>destFile = $destFile<br>originFile = $originFile";
                    } else {
                        $destDir = "/mnt/paphotos/photos/$trs";
                        $destFile = "$destDir/$pn.$idStr.jpg";
                        //$originFile = "/mnt/paphotos/Sketches/$image";
                        $originFile = "/var/www/html/pa/photo_uploader/convertVisionSketch/tmp/$image";
                        //echo "<p>destFile = $destFile<br>originFile = $originFile";
                    }
                    /*  PUT THIS CRAP BACK IN ???
                      if(is_dir($destDir) === false){
                      //echo "<br>destination dir is false";
                      if (FALSE == mkdir($destDir,0777)){
                      //echo "<p>Could not mkdir: $destDir";
                      Debug(1,"Could not mkdir: $destDir");
                      die("ERROR");
                      }
                      Debug(1,"Made destination dir = $destDir");
                      sleep(1);
                      }
                      if (FALSE == copy($originFile, $destFile)) {
                      //echo "<p>ERROR: Could not copy: $originFile | $destFile";
                      Debug(1,"ERROR: Could not copy: $originFile | $destFile");
                      }else{
                      //echo "<br>save new image - ID: $idStr FILE: $destFile SIZE: ".filesize($destFile);
                      Debug(1,"save new image - ID: $idStr FILE: $destFile SIZE: ".filesize($destFile));
                      // delete sketch from dir
                      Debug(1,"unlinking image = $originFile");
                      //unlink($originFile);   // PUT THIS BACK IN ????
                      //unlink("tmp/$image");
                      //echo "<br>unlink file = $originFile";
                      }
                     */
                } else {
                    //echo "<br>ERROR: no rim id found";
                }
            } // end if($dupe == FALSE)
        } // end if(isset($pid) && $pid > 0)
    } // end foreach($myImages as $image)
    //echo "<p>total = $totalCount".
    "<br>dupe count = $dupeCount" .
        "<br>processed = $processedCount";
    function pullPN($pid)
    {
        global $dbNameVision;
        $qs = "select REM_ACCT_NUM from $dbNameVision.real_prop.realmast " .
            "where REM_PID = $pid";
        //echo "<br>qs = $qs";
        $ret = simpleVisionQuery($qs, TRUE);
        if (isset($ret[0]["REM_ACCT_NUM"]) && $ret[0]["REM_ACCT_NUM"] > 0) {
            return $ret[0]["REM_ACCT_NUM"];
        } else {
            return FALSE;
        }
    }
    function insertCommonRecord($trs, $pn)
    {
        global $dbNameVision, $testing;
        $newRimId = pullNewRimId();
        if (isset($newRimId) && $newRimId > 0) {
            $idStr = str_pad($newRimId, 8, "0", STR_PAD_LEFT);
            // ex: RIM_LOCATION = "122306\06-12-23-0000-0020-0010.00320407.jpg"
            $qs = "insert into $dbNameVision.common.reimagesimage " .
                "(RIM_ID,RIM_MNC, RIM_LOCATION, RIM_LOCATION_TYPE) " .
                "values($newRimId, 11054, '$trs\\$pn.$idStr.jpg', 'F')";
            Debug(1, "INSERT common -> $qs");
            //echo "<br>insert common record QS = $qs";
            if ($testing == FALSE) {
                $ret = simpleVisionQuery($qs, FALSE);
            }
            return $newRimId;
        } else {
            Debug(1, "Error with insertCommonRecord - no new rim id - $pn");
            return FALSE;
        }
    }
    function pullNewRimId()
    {
        global $dbNameVision, $testing;
        $qs = "UPDATE $dbNameVision.COMMON.SEQUENCES " .
            "SET SEQ_IMAGE_ID = (SEQ_IMAGE_ID + 1) " .
            "OUTPUT inserted.SEQ_IMAGE_ID as 'SEQ_IMAGE_ID'";
        //echo "<br>pull new rim id QS = $qs";
        if ($testing == FALSE) {
            //$ret = simpleVisionQuery($qs, TRUE);
            $ret = bigVisionQuery($qs, TRUE);
            //echo "<br>pullNewRimId() - rim id pulled = ".$ret["SEQ_IMAGE_ID"];
        } else {
            $ret["SEQ_IMAGE_ID"] = 999;
        }
        //echo "<p>ret = <pre>";
        print_r($ret);
        //echo "</pre>";
        if (isset($ret["SEQ_IMAGE_ID"]) && $ret["SEQ_IMAGE_ID"] > 0) {
            return $ret["SEQ_IMAGE_ID"];
        } else {
            Debug(1, "Error with pullNewRimId - $qs");
            return FALSE;
        }
    }
    function insertRealPropRecord($pid, $bid, $rimId, $fileName, $fileDate)
    {
        global $dbNameVision, $testing;
        $rimLineNum = pullRimLineNum($pid, $bid);
        // per jedw01 3.2.20
        // populate RIM_DESC = 'VISION SKETCH'
        // populate RIM_INTRNL_NOTE = 'APEX SKETCH JPG'
        $str = "RIM_MNC, RIM_PID, RIM_BID, RIM_FILE_NAME, RIM_IMG_DATE, RIM_DESC, RIM_LINE_NUM, RIM_ID, RIM_INTRNL_NOTE";
        $values = "11054, $pid, $bid, '$fileName', '$fileDate', 'VISION SKETCH', $rimLineNum, $rimId, 'APEX SKETCH JPG'";
        $qs = "insert into $dbNameVision.real_prop.reimages ($str) values($values)";
        //echo "<br>insert real prop record QS = $qs";
        Debug(1, "INSERT real prop -> $qs");
        if ($testing == FALSE) {
            $ret = simpleVisionQuery($qs, FALSE);
        }
    }
    function simpleVisionQuery($qsStr, $retFlag)
    {
        global $vDb;
        $ret = false;
        $vDb->selectSQL = $qsStr;
        Debug(9, $vDb->selectSQL);
        if (!$vDb->simpleSQL($vDb->selectSQL)) {
            // returned false - query failed //
            print $vDb->dbErrorMessage . "<br>";
            Debug(1, $vDb->dbErrorMessage);
            exit(0);
        }
        if ($retFlag == TRUE) {
            $ret = $vDb->dataSetArray;
        }
        $vDb->dataSetArray = null;
        return $ret;
    }
    function pullRimLineNum($pid, $bid)
    {
        global $dbNameVision;
        $qs = "select max(rim_line_num)+1 as 'lineNum' " .
            "from $dbNameVision.real_prop.reimages " .
            "where rim_pid = $pid and rim_bid = $bid";
        //echo "<br>pull rim line num QS = $qs";
        $ret = bigVisionQuery($qs, TRUE);
        //echo "<br>pullRimLineNum() - line num pulled = ".$ret["lineNum"];
        if (isset($ret["lineNum"]) && $ret["lineNum"] > 0) {
            return $ret["lineNum"];
        } else {
            return 1;
        }
    }
    function bigVisionQuery($qsStr, $retFlag)
    {
        global $vDb;
        $row = false;
        $vDb->selectSQL = $qsStr;
        Debug(9, $vDb->selectSQL);
        if (!$vDb->bigDataSQL($vDb->selectSQL)) {
            // returned false - query failed //
            print $vDb->dbErrorMessage . "<br>";
            Debug(1, $vDb->dbErrorMessage);
            exit(0);
        }
        if ($retFlag == TRUE) {
            $row = $vDb->prepObject->fetch(PDO::FETCH_ASSOC);
        }
        $vDb->prepObject = null;
        return $row;
    }
    function checkForDupe($pid, $bid, $fileDate)
    {
        global $dbNameVision;
        //echo "<p>file date = ".$fileDate;
        $p = explode("-", $fileDate);
        $yearAgo = date("Y-m-d", mktime(0, 0, 0, $p[1], $p[2], $p[0] - 1));
        //echo "<p>year ago = $yearAgo";
        $yearHalfAgo = date("Y-m-d", mktime(0, 0, 0, $p[1] - 6, $p[2], $p[0] - 1));
        //echo "<p>year HALF ago = $yearHalfAgo";
        //$qs = "select count(*) as 'count' from real_prop.reimages ".
        //      "where rim_pid = $pid and rim_bid = $bid and ".
        //      "RIM_DESC = 'VISION SKETCH' and rim_img_date like '$fileDate%'";
        $qs = "select count(*) as 'count' from real_prop.reimages " .
            "where rim_pid = $pid and rim_bid = $bid and " .
            "RIM_DESC = 'VISION SKETCH' and " .
            "rim_img_date between '$yearHalfAgo' and '$fileDate'";
        if ($pid == $bid) {
            //echo "<br>$pid - $bid";
        }
        //echo "<br>check for dupes QS = $qs";
        $ret = simpleVisionQuery($qs, TRUE);
        return $ret[0]['count'];
    }
    /*
      if($imageId !== FALSE){
      // 3. copy over image
      //get trs
      $p = explode("-",$display_pn);
      $trs = $p[1].$p[2].$p[0];
      //pad id to 8 characters
      $idStr = str_pad($imageId, 8, "0", STR_PAD_LEFT);
      $destDir = "/mnt/paphotos/photos/$trs";
      $destFile = "$destDir/$display_pn.$idStr.jpg";
      $originFile = "$fullPath/$workingDir/$photo"; //$fullPath from requirements.php
      try{
      if(is_dir($destDir) === false){
      if  (FALSE == mkdir($destDir,0777))
      throw new Exception("Could not mkdir: $destDir");
      //if  (FALSE == chmod($destDir,0777))
      //throw new Exception("Could not chmod dir: $destDir");
      sleep(1);
      }
      if (FALSE == copy($originFile, $destFile)) {
      throw new Exception("Could not copy: $originFile | $destFile");
      }else{
      Debug(1,"save new image - ID: $idStr FILE: $destFile SIZE: ".filesize($destFile)." USER: ".$_SESSION["username"]);
      //chmod($destFile, 0666);
      }
      //left off here - reorder picts and unmark old isprimary
      if($isPrimary == TRUE)
      finishIsPrimary($pid,$bid,$imageId,FALSE);
      else
      ////echo "<p>NOT sending to primary function";
      //reorder picts here -- needs a rewrite ???
      ////if(isset($_POST["orderNum"]) && $_POST["orderNum"] > 0)
      //    reorderPhotos($pid,$bid,$imageId,$_POST["orderNum"]);
      //else
      //    //echo "<p>not reordering photos";
      $parcelPhotoID = $imageId;  // why??? - using in designate photo below
      auditTrailRecord($_SESSION['username'],$pid,$imageId,false,$display_pn,"Saved New Photo");
      }
      catch (Exception $e) {
      $errmsg = 'CAUGHT EXCEPTION: ' . $e->getMessage();
      Debug(1, $errmsg);
      $display_msg = $callIT_msg;
      $continue = false;
      }
      } else{
      $display_msg = $callIT_msg;
      $continue = false;
      }
     */
}