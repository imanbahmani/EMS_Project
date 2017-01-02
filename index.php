<?php
if( isset($_POST['checkbox']) && is_array($_POST['checkbox']) ) {
    $checkboxList = implode(',', $_POST['checkbox']);
    DynamicallyQueryGenerator($checkboxList);
}
?>
<html>
<head>
    <meta charset="UTF-8">
    <title>CSV</title>
</head>
<?php
echo '<form action="" method="post">';
DynamicallyCheckBoxGenerator('ambulance_missions');
DynamicallyCheckBoxGenerator('ambulance_regions');
DynamicallyCheckBoxGenerator('call_informations');
DynamicallyCheckBoxGenerator('dr_contents');
DynamicallyCheckBoxGenerator('dr_scripts');
//DynamicallyCheckBoxGenerator('missions');
DynamicallyCheckBoxGenerator('mission_calls');
DynamicallyCheckBoxGenerator('mission_forms');
DynamicallyCheckBoxGenerator('mission_results');
DynamicallyCheckBoxGenerator('organizations');
//DynamicallyCheckBoxGenerator('patient_calls');
DynamicallyCheckBoxGenerator('patient_infos');
DynamicallyCheckBoxGenerator('question_answers');
DynamicallyCheckBoxGenerator('receptions');
DynamicallyCheckBoxGenerator('reception_hospitals');
DynamicallyCheckBoxGenerator('times_missions');
echo '<input type="submit" />';
echo '</form>';
?>

</html>
<?php
function DynamicallyCheckBoxGenerator($tableName) {
    include "conf.php";
    echo 'Table Name: '.$tableName.'<br><br><br>';
    $getColmns = mysqli_query($con," SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '$tableName' ");
    while($row = mysqli_fetch_array($getColmns))
    {
        echo "<input  type='checkbox' name='checkbox[]' value='".$tableName.'.'.$row['COLUMN_NAME']."'>".$row['COLUMN_NAME'].'&nbsp;&nbsp;&nbsp;';
    }
    mysqli_close($con);
    echo '<hr>'.'<br><br><br>';
}
?>
<?php
function DynamicallyQueryGenerator($query) {
    include "conf.php";
    $afterSelect=(explode(",",$query));
//    echo "<br>";
//    print_r($afterSelect);
//    echo "<br>";
//    echo '<hr>'.'<br><br><br>';
    $newArray = array();
    for ($i =   0;  $i  <   sizeof($afterSelect);   $i++)   {
        $newArray[]=strtok($afterSelect[$i], '.');
    }
    $newArray = array_unique($newArray);
    //print_r($newArray);
    $afterFrom = implode(',', $newArray);
//
    for ($i =   0;  $i  <   sizeof($afterSelect);   $i++)   {
        $secondSide=strtok($afterSelect[$i], '.');
        $newWhere[]="call_informations.id=".$secondSide.".call_id";
    }
    $afterWhere = implode(' and ', $newWhere);
    //echo $afterWhere;
//

    //echo '<hr>'.'<br><br><br>';

     $querySend= " SELECT ".$query." FROM   ".$afterFrom." ";
    $result = mysqli_query($con," SELECT ".$query." FROM   ".$afterFrom." ");
//    while($row = mysqli_fetch_array($result))
//    {
//        print_r($row);
//    }
//    mysqli_close($con);
    //echo '<hr>'.'<br><br><br>';
    exportMysqlToCsv('export_csv.csv',$querySend);
}
function exportMysqlToCsv($filename = 'export_csv.csv',$querySend)
{
    include "conf.php";
    $result_export = mysqli_query($con,$querySend);
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