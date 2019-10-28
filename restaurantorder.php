<?php
if(isset($_GET['x1'])&&isset($_GET['x10'])&&isset($_GET['x19'])
&&isset($_GET['x2'])&&isset($_GET['x11'])&&isset($_GET['x20'])
&&isset($_GET['x3'])&&isset($_GET['x12'])&&isset($_GET['x21'])
&&isset($_GET['x4'])&&isset($_GET['x13'])&&isset($_GET['inside'])
&&isset($_GET['x5'])&&isset($_GET['x14'])&&isset($_GET['table'])
&&isset($_GET['x6'])&&isset($_GET['x15'])&&isset($_GET['s'])
&&isset($_GET['x7'])&&isset($_GET['x16'])&&isset($_GET['url'])
&&isset($_GET['x8'])&&isset($_GET['x17'])
&&isset($_GET['x9'])&&isset($_GET['x18'])){

$cuantos=array();

$totaldish=0;
while($totaldish<100){$totaldish++;
array_push($cuantos,number($_GET['x'.$totaldish]));
}
//print_r($cuantos);

$inside=number($_GET['inside']);
$table=preg_replace("/[^0-9]/","",$_GET['table']);
$store=preg_replace("/[^0-9]/","",$_GET['s']);
$url=clean($_GET['url']);
}
else{
header("Location:index.php/".@$_GET['url']);exit();
}

session_start();
if(isset($_SESSION['ide'])){$id=$_SESSION['ide'];}

if(!isset($_SESSION['ide'])){$id=2;}

//if(!isset($_SESSION['ide'])){header("Location:index.php/".@$_GET['url']);exit();}


include("conexion.php");


$query=mysql_query("SELECT * FROM store WHERE ID LIKE '$id'");
if(mysql_num_rows($query)==1){
$row=mysql_fetch_assoc($query);
@$email=$row['EMAIL'];
@$lang=$row['LANG'];
@$currency=$row['CURRENCY'];
@$country=$row['COUNTRY'];
@$card=$row['CARD'];
@$username=$row['NAME'];
@$lastname=$row['LAST_NAME'];
@$birthdate=$row['BIRTH_DATE'];
@$identification=$row['IDENTIFICATION'];
@$phone=$row['PHONE'];
@$mobile=$row['MOBILE'];
@$zip=$row['ZIP'];
@$city=$row['CITY'];
@$province=$row['PROVINCE'];
@$roadtype=$row['ROAD_TYPE'];
@$roadname=$row['ROAD_NAME'];
@$roadnumber=$row['ROAD_NUMBER'];
@$block=$row['BLOCK'];
@$floor=$row['FLOOR'];
@$door=$row['DOOR'];
}

if(empty($email)
||empty($lang)
||empty($currency)
||empty($country)
||empty($username)
||empty($phone)
||empty($zip)
||empty($city)
||empty($province)
||empty($roadtype)
||empty($roadname)){
header("Location:store/account.php?next=".@$_GET['url']);exit();
}


$query=mysql_query("SELECT * FROM store WHERE ID LIKE '$store'");
if(mysql_num_rows($query)==1){
$row=mysql_fetch_assoc($query);
@$storeid=$row['ID'];
@$storeemail=$row['EMAIL'];
@$storelang=$row['LANG'];
@$storecurrency=$row['CURRENCY'];
@$storecountry=$row['COUNTRY'];
@$storephone=$row['PHONE'];
@$storemobile=$row['MOBILE'];
@$storezip=$row['ZIP'];
@$storecity=$row['CITY'];
@$storeprovince=$row['PROVINCE'];
@$storeorder=$row['ORDER'];
@$storepayment=$row['PAYMENT'];
@$storedelivery=$row['DELIVERY'];
@$storepickup=$row['PICKUP'];
@$storeindoor=$row['INDOOR'];
@$storemin=$row['MINIMUMORDER'];
@$storefee=$row['DELIVERYFEE'];
@$storearea=$row['DELIVERYAREA'];
}




$query=mysql_query("SELECT * FROM bills WHERE STOREID LIKE '$store' 
	AND DATE_SUB(NOW(), INTERVAL 10 SECOND) < TIME");
if(mysql_num_rows($query)>0){
header("Location:store/orders.php?order=1");exit();
}//check at least 15 minute between creations




if($inside==0&&$zip!=$storezip){
//header("Location:index.php/".@$_GET['url']."?diferentZipCode=true");exit();
}

if($inside==0&&$storedelivery==0){
header("Location:index.php/".@$_GET['url']."?delivery=off");exit();
}

if($inside==1&&$storeindoor==0){
header("Location:index.php/".@$_GET['url']."?indoor=off");exit();
}

if($inside==2&&$storepickup==0){
header("Location:index.php/".@$_GET['url']."?pickup=off");exit();
}

if($id==$store){
//header("Location:index.php/".@$_GET['url']."?sameAccount=true");exit();
}

$year=date("Y");
$month=date("m");
$day=date("d");
$query=mysql_query("SELECT * FROM bills WHERE STOREID LIKE '$store' 
	 AND YEAR LIKE '$year' 
	 AND MONTH = '$month' 
	 AND DAY = '$day' 
	 AND USERID != '2' 
	 AND STORE_READ IS NULL");
if(mysql_num_rows($query)>9){
header("Location:index.php/".@$_GET['url']."?tooManyOrders=".mysql_num_rows($query));exit();
}//max 10 orders in process today



$pila=array();
$price=array();

$query=mysql_query("SELECT * FROM restaurant WHERE RESTAURANT LIKE '$store'");
if(mysql_num_rows($query)>0){
while($row=mysql_fetch_assoc($query)){
array_push($pila,$row['PRODUCT']);
array_push($price,$row['PRICE']);
}
}

$state=1;
$random=getRandomId();
$ip=preg_replace("/[^0-9.]/","",$_SERVER['REMOTE_ADDR']);
$total=0;
$products="";

for($i=0;$i<$totaldish;$i++){
if($cuantos[$i]>0&&$cuantos[$i]<10&&$price[$i]!="0.00"){
$total+=$cuantos[$i]*$price[$i];
$products.=$cuantos[$i]."-".$pila[$i].":".$price[$i]."_";
}
}//cantidad del producto - nombre del producto - precio del producto


if($storepayment==1&&$card<=$total){
header("Location:index.php/".@$_GET['url']."?notEnoughMoney");exit();
}



if($card>=$total){
mysql_query("UPDATE store SET CARD = CARD-$total WHERE ID = '$id'");
mysql_query("UPDATE store SET CARD = CARD+$total WHERE ID = '$store'");
$state=2;
}


if(date("i")<50){
	if(date("H")<8)
$newtime=mktime(8,0,0,date("m"),date("d"),date("y"));
    else{
if(date("H")>21)
$newtime=mktime(date("H"),0,0,date("m"),date("d"),date("y"));
else
$newtime=mktime(date("H")+1,0,0,date("m"),date("d"),date("y"));
}
}
else{
	if(date("H")<8)
$newtime=mktime(8,0,0,date("m"),date("d"),date("y"));
    else{
if(date("H")>20)
$newtime=mktime(date("H"),0,0,date("m"),date("d"),date("y"));
else
$newtime=mktime(date("H")+2,0,0,date("m"),date("d"),date("y"));
}

}//Hora 8-24



if($inside==0){//pickup
if($total<$storemin){header("Location:index.php/".@$_GET['url']."?order=minNotReached");exit();}
$total=$total+$storefee;
$products.=" ".$roadname." +".$storefee."_";
//if(strpos($storearea, $zip) !== false){header("Location:index.php/".@$_GET['url']."?notSameZip");exit();}
}



if($inside==1&&$table>=0&&$table<100000){//indoor
$roadtype=null;
$roadname="#".$table;
$roadnumber=null;
$block="";
$floor="";
$door="";
if(date("H")==23)
$newtime=mktime(date("H")-1,0,0,date("m"),date("d"),date("y"));
else
$newtime=mktime(date("H"),0,0,date("m"),date("d"),date("y"));
}


$deliverytime=date("Y-m-d H:i:s",$newtime);

$year=date("Y",$newtime);
$month=date("m",$newtime);
$day=date("d",$newtime);
$hour=date("H",$newtime);


if($inside==2){//pickup
$roadtype=null;
$roadname=null;
$roadnumber=null;
}



mysql_query("UPDATE store SET NUMORDERS = NUMORDERS+1 WHERE ID = '$store'");


mysql_query("INSERT INTO bills (STATE,ORDERID,USERID,STOREID,PRODUCTS,PRICE,DELIVERYPLACE,DELIVERYTIME,YEAR,MONTH,DAY,HOUR,TIME,IP,LANG,COUNTRY,CURRENCY,EMAIL,NAME,LAST_NAME,BIRTH_DATE,IDENTIFICATION,PHONE,MOBILE,ZIP,CITY,PROVINCE,ROAD_TYPE,ROAD_NAME,ROAD_NUMBER,BLOCK,FLOOR,DOOR) 
	VALUES ('$state','$random','$id','$store','$products','$total','$inside','$deliverytime','$year','$month','$day','$hour',now(),'$ip','$storelang','$storecountry','$storecurrency','$email','$username','$lastname','$birthdate','$identification','$phone','$mobile','$zip','$city','$province','$roadtype','$roadname','$roadnumber','$block','$floor','$door')");


if($id!=2){
$subject=$bills." ".$random.".pdf - MiFood";
$message="<html><body>
Tu pedido ".$random." está apunto de llegar, a través de este link puedes ver y descargar tu factura de forma digital y sin ningún mal uso de papel.
<a href='http://".$_SERVER['SERVER_NAME']."/store/createpdf.php?qoi=".$random."'>
".$random.".pdf - <b>MiFood</b></a>
<br>
Your order ".$random." is about to come, click this link to watch and download your digital invoice without wasting any paper.
<a href='http://".$_SERVER['SERVER_NAME']."/store/createpdf.php?qoi=".$random."'>
".$random.".pdf - <b>MiFood</b></a>
</body></html>";
$from="From: MiFood <admin@mifood.es>\r\n";
$from.="Content-type:text/html;charset=UTF-8;";

mail($email,$subject,$message,$from);
mail($storeemail,$subject,$message,$from);
}



header("Location:store/createpdf.php?qoi=".$random);exit();

//header("Location:store/orders.php?order=1");



function getRandomId(){
$arraychar='0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
for($arrayi=0;$arrayi<5;$arrayi++)
@$q.=$arraychar[rand(0,35)];
$getrandom=mysql_query("SELECT * FROM bills WHERE ORDERID LIKE '$q'");
if(mysql_num_rows($getrandom)==1)
getRandomId();
else
return $q;
}

function number($q){
$q=substr(preg_replace("/[^0-9]/","",$q),0,1);
return $q;
}

function clean($q){
$q=substr(preg_replace("/[^a-zA-Z0-9_]/","",$q),0,15);
return $q;
}

?>