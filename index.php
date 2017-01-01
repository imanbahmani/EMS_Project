<?php
if( isset($_POST['checkbox']) && is_array($_POST['checkbox']) ) {
    foreach($_POST['checkbox'] as $checkbox) {
        //echo "{$checkbox}";
    }
    echo $checkboxList = implode(', ', $_POST['checkbox']);
    echo '<br>';
    echo $queryGenerator="select ".$checkboxList." ";
    DynamicallyQueryGenerator($checkboxList);
}
?>
<html>
<?php
echo '<form action="" method="post">';
DynamicallyCheckBoxGenerator('ambulance_missions');
DynamicallyCheckBoxGenerator('ambulance_regions');
DynamicallyCheckBoxGenerator('call_informations');
DynamicallyCheckBoxGenerator('dr_contents');
DynamicallyCheckBoxGenerator('dr_scripts');
DynamicallyCheckBoxGenerator('missions');
DynamicallyCheckBoxGenerator('mission_calls');
DynamicallyCheckBoxGenerator('mission_forms');
DynamicallyCheckBoxGenerator('mission_results');
DynamicallyCheckBoxGenerator('organizations');
DynamicallyCheckBoxGenerator('patient_calls');
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
        echo "<input type='checkbox' name='checkbox[]' value='".$tableName.'.'.$row['COLUMN_NAME']."'>".$row['COLUMN_NAME'].'&nbsp;&nbsp;&nbsp;';
    }
    mysqli_close($con);
    echo '<hr>'.'<br><br><br>';
}
?>

<?php
function DynamicallyQueryGenerator($query) {
    include "conf.php";
    $result = mysqli_query($con," SELECT ".$query." FROM  ambulance_missions,ambulance_regions,call_informations,dr_contents,dr_scripts,missions,mission_calls,mission_forms,mission_results,organizations,patient_calls,patient_infos,question_answers,receptions,reception_hospitals,times_missions ");
    while($row = mysqli_fetch_array($result))
    {
        print_r($row);
    }
    mysqli_close($con);
    echo '<hr>'.'<br><br><br>';
}
?>
