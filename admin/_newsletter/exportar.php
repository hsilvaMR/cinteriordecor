<?php
include('../../_connect.php');

$output = '';
$sql = "SELECT * FROM newsletter";
$result = mysqli_query($lnk, $sql);
if(mysqli_num_rows($result) > 0)
{
   $output .= '
            <table class="table" bordered="1">
             <tr>
                  <th>#</th>
                  <th>Email</th>
                  <th>Data</th>
             </tr>';

   while($row = mysqli_fetch_array($result))
   {
        $output .= '
             <tr>
                  <td>'.$row["id"].'</td>
                  <td>'.$row["email"].'</td>
                  <td>'.$row["data"].'</td>
             </tr>
        ';
   }
   $output .= '</table>';
   //header("Content-Type: application/vnd.ms-excel");
   header("Content-Type: application/xls");
   header("Content-Disposition: attachment; filename=Newsletters.xls");
   header("Pragma: no-cache");
   header("Expires: 0");
   echo $output;
}else{ header('Location: /admin/newsletters');}

/*$i = 0;
$html[$i] = "";
$html[$i] .= "<table>";
$html[$i] .= "<tr>";
$html[$i] .= "<td><b>#</b></td>";
$html[$i] .= "<td><b>Email</b></td>";
$html[$i] .= "<td><b>Data</b></td>";
$html[$i] .= "</tr>";
$html[$i] .= "</table>";

$query = mysqli_query($lnk,"SELECT * FROM email");
$contar = mysqli_num_rows($query);
while($linha = mysqli_fetch_array($query)){
	$id = $linha['id'];
    $email = $linha['email'];
    $data = $linha['data'];
	//$nome = mb_convert_encoding($nome, 'UTF-16LE', 'UTF-8');

	$i++;
	$html[$i] .= "<table>";
	$html[$i] .= "<tr>";
	$html[$i] .= "<td>$i</td>";
	$html[$i] .= "<td>$email</td>";
	$html[$i] .= "<td>$data</td>";
	$html[$i] .= "</tr>";
	$html[$i] .= "</table>";
}

$arquivo = 'emails.xls';
header ("Expires: Mon, 11 Jan 2020 18:00:00 GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/x-msexcel");
header ("Content-Disposition: attachment; filename={$arquivo}" );
header ("Content-Description: PHP Generated Data" );

for($i=0;$i<=$contar;$i++){
    echo $html[$i];
}*/
?>