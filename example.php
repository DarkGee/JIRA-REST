<?
##################################################################################
#
# include REST functions
#
	require_once("rest_functions.inc.php");
#
##################################################################################
#
# 
#
	error_reporting(E_ALL | E_STRICT);
	ini_set('display_errors', TRUE);
#
#
#
	echo "<pre>".PHP_EOL;
#
##################################################################################
#
# Issue dfor Testing
#
	$key = "TEST-1";
#
##################################################################################
#
# getestete Funktionen
#

### create Issue
	$new_issue = array(
        "fields" => array(
                "project" => array("key" => "DCS"),
                "summary" => "Test via REST",
                "description" => "Description of issue goes here.",
                "issuetype" => array("name" => "Request"),
				"customfield_10301" => array("value" => "Data Center Service (Run)"),
				"customfield_10303" => array("value" => "de.kae.bs"),
				"reporter" => array("name" => "grubits")
		)
	);
//	$result = create_issue($new_issue);

### update Summary
	$summary = "Update summary works fine!";
//	$result = update_summary($key, $summary);

### update Description
	$description = "Update descrption works fine!";
//	$result = update_description($key, $description);

### comment Issue
	$comment = " () /\ (?) *Test-Kommentar* {noformat} Blafasel ".time()."{noformat}";
//	$result = comment_issue($key, $comment);

### edit Reporter
	$reporter = "grubits";
//	$result = set_reporter($key, $reporter);

### edit Assignee
	$assignee = "grubits";
//	$result = set_assignee($key, $assignee);

### remove Assignee
//	$result = remove_assignee($key);

### add Watcher
	$watcher = "grubits";
//	$result = add_watcher($key, $watcher);

### remove Watcher
	$watcher = "grubits";
//	$result = remove_watcher($key, $watcher);

### get Watchers
//	$result = get_watcher($key);

### add Label
	$label = "Tested_by_Grubits";
//	$result = add_label($key, $label);

### remove Label
	$label = "Tested_by_Grubits";
//	$result = remove_label($key, $label);

### set Priority
	$priority = "1";
//	$result = set_priority($key, $priority);

### get Priority
//	$result = get_priority();
//	$result = get_priority($key);

### get Transitions
//	$result = get_transitions($key);

### get Status
//	$result = get_status();
//	$result = get_status($key);

### get Issuetype
	$project = "DCS";
//	$result = get_issuetype();
//	$result = get_issuetype($key, "issue");
//	$result = get_issuetype($project, "project");

### get Resolution
//	$result = get_resolution();
//	$result = get_resolution($key);
#
##################################################################################
#
# show return value
#
	echo var_dump($result);
#
##################################################################################
#
	echo "</pre>";
?>
