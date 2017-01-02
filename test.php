<?php
// call export function
exportMysqlToCsv('export_csv.csv');
// export csv
function exportMysqlToCsv($filename = 'export_csv.csv')
{
    include "conf.php";
    $result_export = mysqli_query($con," SELECT ambulance_missions.id,ambulance_regions.property_code FROM ambulance_missions,ambulance_regions ");
    $f_export = fopen('php://temp', 'wt');
    $first_export = true;
    while ($row_export = $result_export->fetch_assoc()) {
        if ($first_export) {
            fputcsv($f_export, array_keys($row_export));
            $first_export = false;
        }
        fputcsv($f_export, $row_export);
    } // end while
    $con->close();
    $size_export = ftell($f_export);
    rewind($f_export);
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Content-Length: $size_export");
    // Output to browser with appropriate mime type, you choose ;)
    header("Content-type: text/x-csv");
    header("Content-type: text/csv");
    header("Content-type: application/csv");
    header("Content-Disposition: attachment; filename=$filename");
    fpassthru($f_export);
    exit;
}
?>