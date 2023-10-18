<?php
// ============
// Vision Class
// ============
class Vision
{
    private
    $log = "";
    private
    $settings = "";
    private
    $vision_connection = "";
    private
    $sketches_mount = "/mnt/paphotos/Sketches";
    // =================
    // Class Constructor
    // =================
    public
        function __construct(
    ) {
        // Open the Log
        $this->log = fopen("../sketches/scripts/sketches.log", "a");
        if ($this->log === false) {
            error_log("Vision+ : Unable to open log file");
            exit();
        }
        $this->log(str_repeat("*", 50));
        // Get Settings
        $this->settings = new SimpleXMLElement((file_exists("../xml/settings.xml")
            ? file_get_contents("../xml/settings.xml") : "<settings/>"));
        if ($this->settings->count() === 0) {
            error_log("Vision+ : Unable to initialize settings");
            exit();
        }
        // Open Database Connections
        $this->vision_connection = $this->connect_vision();
    }
    // ====================================
    // Return a Vision Database Connection.
    // ====================================
    public
        function connect_vision(
    ) {
        try {
            $server = (string) ($this->settings->VisionDatabaseServer ?? "");
            $database = (string) ($this->settings->VisionDatabase ?? "");
            $user = (string) ($this->settings->VisionUser ?? "");
            $password = (string) ($this->settings->VisionPassword ?? "");
            $connection = new PDO(
                "dblib:host={$server};database={$database}",
                $user,
                $password
            );
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch (PDOException | Exception $e) {
            $this->log($e->getMessage());
            exit();
        }
        return $connection;
    }
    // ===========================
    // Return a Parcel from Vision
    // ===========================
    private
        function get_parcel(
        $parcel_number = ""
    ) {
        $SQL = "SELECT rem.rem_pid AS parcel_pid, prc.prc_batch_num AS parcel_staff_area
            FROM real_prop.realmast AS rem
            LEFT JOIN real_prop.parcel AS prc
            ON rem.rem_pid = prc.prc_pid
            AND rem.rem_mnc = prc.prc_mnc
            WHERE rem.rem_acct_num = '{$parcel_number}'";
        $parcel = $this->vision_connection->query($SQL)->fetch(PDO::FETCH_ASSOC);
        return $parcel;
    }
    // =============================
    // Log a message to the Log File
    // =============================
    private
        function log(
        $message = ""
    ) {
        fwrite($this->log, date("Y-m-d H:i A") . " : " . "{$message} \n");
    }
    // =========================
    // Process CitizenServe Data
    // =========================
    public
        function process(
    ) {
        $this->log("Starting Vision+ Sketch Process");
        $this->move_sketches();
        $this->log("Vision+ Sketch Process Complete");
    }
    // ====================
    // Move Vision Sketches
    // ====================
    private
        function move_sketches(
    ) {
        $this->log("Vision+ Processing Sketches");
        $sketch_count = 0;
        $sketches = array_slice(scandir($this->sketches_mount), 2);
        print_r($sketches);
        die();
        foreach ($sketches as $sketch) {
            list($parcel_id, $building_id) = explode("_", $sketch);
            $building_id = preg_replace('/\\.[^.\\s]{3,4}$/', '', $building_id);
            // Check for duplicate sketch
            $file_date = date(
                "Y-m-d",
                filemtime("{$this->sketches_mount}/{$sketch}")
            );
            $duplicate = $this->checkForDuplicateSketch(
                $parcel_id,
                $building_id,
                $file_date
            );
            //echo $file_date.PHP_EOL;
            die();
        }
        $this->log("Vision+ Processed {$sketch_count} Permits");
        $this->log("Vision+ Completed Processing Sketches");
    }
    // ============================
    // Return Tax Group Description
    // ============================
    private
        function getTaxGroupDescription(
        $tax_group_description = ""
    ) {
        $description = '';
        switch ($tax_group_description) {
            case "Unincorporated":
                $description = "Putnam County";
                break;
            case "Uninc. - Hasting Drain Dist":
            case "Unincorporated - Hastings Drainage Dist":
                $description = "Putnam County - Hastings Drainage Dist";
                break;
            case "Uninc. Suwannee WMD":
            case "Unincorporated - Suwannee WMD";
                $description = "Putnam County - Suwannee WMD";
                break;
        }
        return $description;
    }
    // ==========================
    // Check for Duplicate Sketch
    // ==========================
    private
        function checkForDuplicateSketch(
        $parcel_id,
        $building_id,
        $file_date
    ) {
        //echo "file date = ".$file_date.PHP_EOL;
        $p = explode("-", $file_date);
        $yearAgo = date("Y-m-d", mktime(0, 0, 0, $p[1], $p[2], $p[0] - 1));
        //echo "year ago = $yearAgo".PHP_EOL;
        $yearHalfAgo = date("Y-m-d", mktime(0, 0, 0, $p[1] - 6, $p[2], $p[0] - 1));
        //echo "year HALF ago = $yearHalfAgo".PHP_EOL;
        $qs = "select count(*) as 'count' from real_prop.reimages " .
            "where rim_pid = $parcel_id and rim_bid = $building_id and " .
            "RIM_DESC = 'VISION SKETCH' and " .
            "rim_img_date between '$yearHalfAgo' and '$file_date'";
        if ($parcel_id == $building_id) {
            //echo "$parcel_id - $building_id".PHP_EOL;
        }
        //echo "check for dupes QS = $qs".PHP_EOL;
        die();
        //        $ret = simpleVisionQuery($qs, TRUE);
//
//        return $ret[0]['count'];
//        $SQL = "select PSA_STREET_NUM_CHAR, PSA_STREET, PSA_STREET_PREFIX, PSA_CITY, PSA_STATE, PSA_ZIP
//              from V7_VISION.COMMON.SITE_ADDRESS
//             where PSA_SITE_ID = '{$site_id}'";
//
//        $site_address = $this->vision_connection->query($SQL)->fetch(PDO::FETCH_ASSOC);
//
//        return $site_address;
    }
    // =================================
    // Return a Site Address from Vision
    // =================================
    private
        function getReplacementValues(
        $prx_pid = ""
    ) {
        $SQL = "select PSA_STREET_NUM_CHAR, PSA_STREET, PSA_STREET_PREFIX, PSA_CITY, PSA_STATE, PSA_ZIP
              from V7_VISION.COMMON.SITE_ADDRESS
             where PSA_SITE_ID = '{$site_id}'";
        $site_address = $this->vision_connection->query($SQL)->fetch(PDO::FETCH_ASSOC);
        return $site_address;
    }
}
?>