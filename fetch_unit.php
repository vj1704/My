<?php
//fetch.php

$connect = mysqli_connect("localhost", "root", "", "phpzag_demos");
;

$query = "SELECT * FROM quan_pivot  ";

/*if($_POST["is_date_search"] == "yes")
{
 $query .= 'product_date BETWEEN "'.$_POST["start_date"].'" AND "'.$_POST["end_date"].'" AND ';
}
*/
$query1 = '';

if($_POST["length"] != -1)
{
 $query1 = 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}

$number_filter_row = mysqli_num_rows(mysqli_query($connect, $query));

$result = mysqli_query($connect, $query . $query1);

$data = array();
$cnt=1;

while($row = mysqli_fetch_array($result))
{
 
			$inventoryInHand = ($row['product_quantity'] + $row['added_quantity']) - $row['quantity'];
		
 $sub_array = array();
 $sub_array[] = $row["brand_id"];
 $sub_array[] = $row["brand_name"];
 $sub_array[] = $row["quantity"];
 $sub_array[] = $inventoryInHand;
 $sub_array[] = $row["90ml"];
 $sub_array[] = $row["180ml"];
 $sub_array[] = $row["330ml"];
 $sub_array[] = $row["500ml"];
 $sub_array[] = $row["600ml"];
 $sub_array[] = $row["650ml"];
 $sub_array[] = $row["750ml"];
 $data[] = $sub_array;
 $cnt=$cnt+1;
}

function get_all_data($connect)
{
 $query = "SELECT * FROM quan_pivot";

 $result = mysqli_query($connect, $query);
 return mysqli_num_rows($result);
}

$output = array(
 "draw"    => intval($_POST["draw"]),
 "recordsTotal"  =>  get_all_data($connect),
 "recordsFiltered" => $number_filter_row,
 "data"    => $data
);

echo json_encode($output);

?>

