<?php
///

require_once 'CosineSimilarity.php';

function getSimilarityCoefficient( $item1, $item2 ) {
	
//	$item1 = explode( $separator, $item1 );
	//$item2 = explode( $separator, $item2 );
	$arr_intersection = array_intersect( $item1, $item2 );
	$arr_union = array_merge( $item1, $item2 );
	$coefficient = count( $arr_intersection ) / count( $arr_union );
	
	return $coefficient;
}


///



  // Masukkan informasi file ke database
  $konek = mysqli_connect("localhost","root","","dbstbi");
  
$query = "SELECT token FROM `dokumen` where nama_file='./files/UU-12-92.pdf'";
$result =mysqli_query($konek, $query);
$undang1 = array();
if (mysqli_num_rows($result) > 0) {
while ($row = mysqli_fetch_assoc($result)) {
	//$userID = $row{'User-ID'};
    //$books[$userID][$row{'Book-Title'}] =  $row{'Book-Rating'};
$undang1[]=$row{'token'};	
    //printf("Token: %s ", $row['token']);  
	//printf("Token: %s ", $undang1);  
}

} else {
    echo "0 results";
}

$query2 = "SELECT token  FROM `dokumen` where nama_file='./files/UU-12-92.pdf'";
$result2 =mysqli_query($konek, $query2);

if (mysqli_num_rows($result2) > 0) {
$undang2 = array();

while ($row = mysqli_fetch_assoc($result2)) {
		$undang2[]=$row{'token'};	
   	
};

} else {
    echo "0 results";
}


echo "Similaritas <br>";
$hasil=getSimilarityCoefficient( $undang1, $undang2 );
echo "Similaritas Jaccard = ".$hasil."<br>";



////

$query3 = "SELECT token, count(*) as tf FROM `dokumen` where nama_file='./files/UU-12-92.pdf' group by token";
$result3 =mysqli_query($konek, $query3);
$undang3 = array();

$panjang=mysqli_num_rows($result3);
if (mysqli_num_rows($result3) > 0) {
$undang3=mysqli_fetch_assoc($result3);	
while ($row = mysqli_fetch_assoc($result2)) {
		$indeks=$row{'token'};
		$undang3[]=$indeks;
		$undang3[$indeks]=$row{'tf'}	;
   	
};
} else {
    echo "0 results";
}

///
////
  
$query4 = "SELECT token,count(*) as tf FROM `dokumen` where nama_file='./files/UU-12-92.pdf' group by token";
$result4 =mysqli_query($konek, $query4);
$undang4 = array();

if (mysqli_num_rows($result4) > 0) 
{
$undang4=mysqli_fetch_assoc($result4);	
while ($row = mysqli_fetch_assoc($result4)) {
		$indeks=$row{'token'};
		$undang4[]=$indeks;
		//echo "Freq=".$row{'tf'}	;
		$undang4[$indeks]=$row{'tf'}	;
   	
};

} else {
    echo "0 results";
}

$cs = new CosineSimilarity();

$result1 = $cs->similarity($undang3,$undang4); // similarity of 1 and 2 
echo "Similaritas cosine = ".$result1."<br>";

///


mysqli_close($konek);
?>