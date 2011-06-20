<?
/*	CREATED BY:
 *         ___      _ __________          _ ____ _____ _____
 *    ___ / _ \  __| |___ /___  |_      _/ | ___|___  |___ / _ __
 *   / __| | | |/ _` | |_ \  / /\ \ /\ / / |___ \  / /  |_ \| '__|
 *  | (__| |_| | (_| |___) |/ /  \ V  V /| |___) |/ /  ___) | | _
 * (_)___|\___/ \__,_|____//_/    \_/\_/ |_|____//_/  |____/|_|(_)
 * 
*/

function extract_order_status(&$array_item, $key) {
	global $client_order_statuses;
	$array_item["status_text"] = $client_order_statuses[$array_item["status"]];
}

function getFilterValue($key, $values) {
	if (isset($values[$key])) { 
		return $values[$key]["value"];
	}
	return false;
}

function getPropertyDisplayValue($prop, $value, $yes_no_array=array("y"=>"da", "n"=>"nu")) {
	if ($prop["type"] == "numeric") {
		return trim($value["numeric_value"]." ".$value["value"]);
	} else if ($prop["type"] == "fixed") {
		return $value["value"];
	} else if ($prop["type"] == "yes_no") {
		return trim($yes_no_array[$value["yes_no_value"]]." ".$value["value"]);
	}
}

?>