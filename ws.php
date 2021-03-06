<?php

require_once("configs.php");

if (!array_key_exists("lauf", $_GET)) {
    header("HTTP/1.0 400 Bad Request");
    header("Content-Type: text/plain");
    die("'?lauf=' required");
}

$event_id = $_GET["lauf"];

require_once("json-config.php");
$db = new PDO($dsn, $username, $password);

$meta_query = $db->prepare("SELECT CompDate,
                                   EventDescription,
                                   CompSite
                            FROM $tabResultHeader
                            WHERE id = ?");
$meta_query->execute(array($event_id));
$meta = $meta_query->fetchAll();
if (count($meta) == 0) {
    header("HTTP/1.0 404 File Not Found");
    header("Content-Type: text/plain");
    die("Event not found");
}

$cat_query = $db->prepare("SELECT CategoryName,
                                  CategoryNameLong,
                                  CatLength,
                                  CatClimb
                           FROM $tabResultCategories
                           WHERE ResFK = ?");
$cat_query->execute(array($event_id));
$categories = $cat_query->fetchAll();

$res_query = $db->prepare("SELECT c.CategoryName,
                                  r.Position,
                                  r.CourseTime,
                                  p.FirstLastName,
                                  cl.ClubName,
                                  s.StatusCode
                           FROM $tabResultData r,
                                $tabResultNames p,
                                $tabResultCategories c,
                                $tabResultClubs cl,
                                $tabResultStatus s
                           WHERE r.ResFK = ?
                             AND r.NameFK = p.NamePK
                             AND r.CatFK = c.CatPK
                             AND r.ClubFK = cl.ClubPK
                             AND r.StatusFK = s.StatusPK;");
$res_query->execute(array($event_id));
$results = $res_query->fetchAll();

$event = array( "date" => date("c", strtotime($meta[0]["CompDate"])),
                "name" => $meta[0]["EventDescription"],
                "location" => $meta[0]["CompSite"],
                "categories" => array() );

foreach($categories as $category) {
    $event["categories"][$category["CategoryName"]] =  array( "name" => $category["CategoryNameLong"],
                                                              "distance" => $category["CatLength"],
                                                              "climb" => $category["CatClimb"],
                                                              "results" => array() );
}

foreach($results as $data) {
    $result = array( "position" => $data["Position"],
                     "name" => html_entity_decode($data["FirstLastName"]),
                     "club" => html_entity_decode($data["ClubName"]),
                     "time" => $data["CourseTime"],
                     "status" => $data["StatusCode"] );
    array_push($event["categories"][$data["CategoryName"]]["results"], $result);
}

header("Content-Type: application/json");
print json_encode($event);

?>
