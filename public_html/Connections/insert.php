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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "alumni_form")) {
  $insertSQL = sprintf("INSERT INTO alumni_listing (kulliyyah, programme, name, address, phone_no, handphone, email) VALUES (%s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['kullyyiah'], "int"),
                       GetSQLValueString($_POST['programme'], "int"),
                       GetSQLValueString($_POST['name'], "text"),
                       GetSQLValueString($_POST['address'], "text"),
                       GetSQLValueString($_POST['phone'], "text"),
                       GetSQLValueString($_POST['mobile'], "text"),
                       GetSQLValueString($_POST['email'], "text"));

  mysql_select_db($database_mycon, $mycon);
  $Result1 = mysql_query($insertSQL, $mycon) or die(mysql_error());

  $insertGoTo = "list.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Untitled Document</title>
</head>

<body>
<form action="<?php echo $editFormAction; ?>" id="alumni_form" name="alumni_form" method="POST">
  <table width="100%" border="1">
    <tr>
      <td>Kulliyyah</td>
      <td><label for="kullyyiah"></label>
      <input type="text" name="kullyyiah" id="kullyyiah" /></td>
    </tr>
    <tr>
      <td>programme</td>
      <td><label for="programme"></label>
      <input type="text" name="programme" id="programme" /></td>
    </tr>
    <tr>
      <td>name</td>
      <td><label for="name"></label>
      <input type="text" name="name" id="name" /></td>
    </tr>
    <tr>
      <td>address</td>
      <td><label for="address"></label>
      <input type="text" name="address" id="address" /></td>
    </tr>
    <tr>
      <td>phone</td>
      <td><label for="adr"></label>
        <label for="phone"></label>
      <input type="text" name="phone" id="phone" /></td>
    </tr>
    <tr>
      <td>mobile</td>
      <td><label for="mobile"></label>
      <input type="text" name="mobile" id="mobile" /></td>
    </tr>
    <tr>
      <td>email</td>
      <td><label for="email"></label>
      <input type="text" name="email" id="email" /></td>
    </tr>
  </table>
  <input name="Submit" type="submit" value="Submit" />
  <input type="hidden" name="MM_insert" value="alumni_form" />
</form>
</body>
</html>