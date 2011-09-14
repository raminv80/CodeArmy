<?php require_once('../Connections/mycon.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_alumni_listing = 20;
$pageNum_alumni_listing = 0;
if (isset($_GET['pageNum_alumni_listing'])) {
  $pageNum_alumni_listing = $_GET['pageNum_alumni_listing'];
}
$startRow_alumni_listing = $pageNum_alumni_listing * $maxRows_alumni_listing;

mysql_select_db($database_mycon, $mycon);
$query_alumni_listing = "SELECT * FROM alumni_listing";
$query_limit_alumni_listing = sprintf("%s LIMIT %d, %d", $query_alumni_listing, $startRow_alumni_listing, $maxRows_alumni_listing);
$alumni_listing = mysql_query($query_limit_alumni_listing, $mycon) or die(mysql_error());
$row_alumni_listing = mysql_fetch_assoc($alumni_listing);

if (isset($_GET['totalRows_alumni_listing'])) {
  $totalRows_alumni_listing = $_GET['totalRows_alumni_listing'];
} else {
  $all_alumni_listing = mysql_query($query_alumni_listing);
  $totalRows_alumni_listing = mysql_num_rows($all_alumni_listing);
}
$totalPages_alumni_listing = ceil($totalRows_alumni_listing/$maxRows_alumni_listing)-1;

$queryString_alumni_listing = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_alumni_listing") == false && 
        stristr($param, "totalRows_alumni_listing") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_alumni_listing = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_alumni_listing = sprintf("&totalRows_alumni_listing=%d%s", $totalRows_alumni_listing, $queryString_alumni_listing);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Untitled Document</title>
</head>

<body>
<table border="0">
  <tr>
    <td><?php if ($pageNum_alumni_listing > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_alumni_listing=%d%s", $currentPage, 0, $queryString_alumni_listing); ?>">First</a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_alumni_listing > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_alumni_listing=%d%s", $currentPage, max(0, $pageNum_alumni_listing - 1), $queryString_alumni_listing); ?>">Previous</a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_alumni_listing < $totalPages_alumni_listing) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_alumni_listing=%d%s", $currentPage, min($totalPages_alumni_listing, $pageNum_alumni_listing + 1), $queryString_alumni_listing); ?>">Next</a>
        <?php } // Show if not last page ?></td>
    <td><?php if ($pageNum_alumni_listing < $totalPages_alumni_listing) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_alumni_listing=%d%s", $currentPage, $totalPages_alumni_listing, $queryString_alumni_listing); ?>">Last</a>
        <?php } // Show if not last page ?></td>
  </tr>
</table>
<?php if ($totalRows_alumni_listing > 0) { // Show if recordset not empty ?>
  <?php do { ?>
    <table width="100%" border="1">
      <tr>
        <td>id</td>
        <td>Kulliah</td>
        <td>Programme</td>
        <td>Name</td>
        <td>Address</td>
        <td>phone no</td>
        <td>handphone</td>
        <td>email</td>
      </tr>
      <tr>
        <td><?php echo $row_alumni_listing['id']; ?></td>
        <td><?php echo $row_alumni_listing['kulliyyah']; ?></td>
        <td><?php echo $row_alumni_listing['programme']; ?></td>
        <td><?php echo $row_alumni_listing['name']; ?></td>
        <td><?php echo $row_alumni_listing['address']; ?></td>
        <td><?php echo $row_alumni_listing['phone_no']; ?></td>
        <td><?php echo $row_alumni_listing['handphone']; ?></td>
        <td><?php echo $row_alumni_listing['email']; ?></td>
      </tr>
    </table>
    <?php } while ($row_alumni_listing = mysql_fetch_assoc($alumni_listing)); ?>
  <?php } // Show if recordset not empty ?>
<?php echo $row_alumni_listing['email']; ?>
</body>
</html>
<?php
mysql_free_result($alumni_listing);
?>
