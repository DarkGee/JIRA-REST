<?php
	require_once(config.inc.php);

##################################################################################
#
# Jira - REST Grundfunktionen
#
	function jira_put($resource, $data) {
		$jdata = json_encode($data);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $GLOBALS["rest_server"]. '/rest/api/latest/' .$resource);
		curl_setopt($ch, CURLOPT_USERPWD, $GLOBALS["rest_username"].":".$GLOBALS["rest_password"]);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_VERBOSE, 1);
		curl_setopt($ch, CURLOPT_SSLVERSION,3);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0); 
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json','Content-Type: application/json'));
		curl_setopt($ch, CURLOPT_POSTFIELDS, $jdata);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
		$result = curl_exec($ch);
		$error = curl_error($ch);
		if($error) {
			return "\ncURL Error: ".$error;
		}
		curl_close($ch);
		return json_decode($result);
	}

	function jira_post($resource, $data) {
		$jdata = json_encode($data);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_USERPWD, $GLOBALS["rest_username"].":".$GLOBALS["rest_password"]);
		curl_setopt($ch, CURLOPT_URL, $GLOBALS["rest_server"].'/rest/api/latest/'.$resource);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_VERBOSE, 1);
		curl_setopt($ch, CURLOPT_SSLVERSION,3);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0); 
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
		curl_setopt($ch, CURLOPT_POSTFIELDS, $jdata);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		$result = curl_exec($ch);
		$error = curl_error($ch);
		if($error) {
			return "\ncURL Error: ".$error;
		}
		curl_close($ch);
		return json_decode($result);
	}
	
	function jira_get($resource) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_USERPWD, $GLOBALS["rest_username"].":".$GLOBALS["rest_password"]);
		curl_setopt($ch, CURLOPT_URL, $GLOBALS["rest_server"].'/rest/api/latest/'.$resource);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_VERBOSE, 1);
		curl_setopt($ch, CURLOPT_SSLVERSION,3);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0); 
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json', 'Content-Type: application/json'));
		$result = curl_exec($ch);
		$error = curl_error($ch);
		if($error) {
			return "\ncURL Error: ".$error;
		}
		curl_close($ch);
		return json_decode($result, TRUE);
	}
	
	function jira_delete($resource, $data) {
		$jdata = json_encode($data);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $GLOBALS["rest_server"].'/rest/api/latest/'.$resource);
		curl_setopt($ch, CURLOPT_USERPWD, $GLOBALS["rest_username"].":".$GLOBALS["rest_password"]);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_VERBOSE, 1);
		curl_setopt($ch, CURLOPT_SSLVERSION,3);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0); 
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json', 'Content-Type: application/json'));
		curl_setopt($ch, CURLOPT_POSTFIELDS, $jdata);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
		$result = curl_exec($ch);
		$error = curl_error($ch);
		if($error) {
			return "\ncURL Error: ".$error;
		}
		curl_close($ch);
		return json_decode($result);
	}
#
##################################################################################
#
# Jira - REST - erweiterte und vereinfachte Funktionen
#
	function create_issue($issue) {
		return jira_post('issue/', $issue);
	}
	
	function update_issue($key, $fields) {
		return jira_put('issue/'.$key, $fields);
	}

	function search_issue($issue) {
		return jira_get('search', $issue);
	}

	function comment_issue($key, $comment) {
		$fields = array(
			"update" => array(
				"comment" => array(
					array(
						"add" => array(
							"body" => $comment
						)
					)
				)
			)
		);
		return jira_put('issue/'.$key, $fields);
	}

	function update_summary($key, $summary) {
		$fields = array(
			"fields" => array(
				"summary" => $summary,
			)
		);
		return jira_put('issue/'.$key, $fields);
	}

	function update_description($key, $description) {
		$fields = array(
			"update" => array(
				"description" => array(
					array (
						"set" => $description,
					),
				)
			)
		);
		return jira_put('issue/'.$key, $fields);
	}
#
# JIRA - REST - Reporter SET
#	
	function set_reporter($key, $reporter) {
		$fields = array(
			"update" => array(
				"reporter" => array(
					array(
						"set" => array (
							"name" => $reporter
						)
					)
				)
			)
		);
		return jira_put('issue/'.$key, $fields);
	}
#
# JIRA - REST - Assignee SET, REMOVE
#	
	function set_assignee($key, $assignee) {
		$fields = array(
			"update" => array(
				"assignee" => array(
					array(
						"set" => array (
							"name" => $assignee
						)
					)
				)
			)
		);
		return jira_put('issue/'.$key, $fields);
	}

	function remove_assignee($key) {
		return set_assignee($key, "");
	}
#
# JIRA - REST - Watcher ADD, REMOVE, GET
#	
	function add_watcher($key, $watcher) {
		return jira_post('issue/'.$key.'/watchers', $watcher);
	}
	
	function remove_watcher($key, $watcher) {
#		return jira_delete('issue/'.$key.'/watchers?'.$watcher, 'username:'.$watcher);
		return "Does not work, yet!";
	}

	function get_watcher($key) {
		return jira_get('issue/'.$key.'/watchers');
	}
#
# JIRA - REST - Labels ADD, REMOVE
#
	function add_label($key, $label) {
		$fields = array(
			"update" => array(
				"labels" => array(
					array(
						"add" => $label,
					)
				)
			)
		);	
		return jira_put('issue/'.$key, $fields);
	}

	function remove_label($key, $label) {
		$fields = array(
			"update" => array(
				"labels" => array(
					array(
						"remove" => $label,
					)
				)
			)
		);	
		return jira_put('issue/'.$key, $fields);
	}
#
# JIRA - REST - Priority SET
#
	function set_priority($key, $priority) {
		$fields = array(
			"update" => array(
				"priority" => array(
					array(
						"set" => array(
							"id" => $priority,
						)
					)
				)
			)
		);
		return jira_put('issue/'.$key, $fields);
	}
#
# JIRA - REST - Priority GET
#
	function get_priority($key="") {
		if ($key != "") {
			$result = jira_get('issue/'.$key);
			$result = $result["fields"]["priority"];
		} else {
			return jira_get('priority');
		}
		return $result;
	}
#
# JIRA - REST - Transition GET
#
	function get_transitions($key) {
		return jira_get('issue/'.$key.'/transitions');
	}
#
# JIRA - REST - Status GET
#
	function get_status($key="") {
		if ($key != "") {
			$result = jira_get('issue/'.$key);
			$result = $result["fields"]["status"];
		} else {
			$result = jira_get('status');
		}
		return $result;
	}
#
# JIRA - REST - Resolution GET
#
	function get_resolution($key="") {
		if ($key != "") {
			$result = jira_get('issue/'.$key);
			$result = $result["fields"]["resolution"];
		} else {
			$result = jira_get('resolution');
		}
		return $result;
	}
#
# JIRA - REST - Project GET
#
	function get_project($key) {
		return jira_get('project');
	}
#
# JIRA - REST - Issuetypes GET
#
	function get_issuetype($data="", $type="") {
		switch($type) {
			case "project":
				$result = jira_get('issue/createmeta?projectKeys='.$data);
				$result = $result["projects"][0]["issuetypes"];
				break;
			case "issue":
				$result = jira_get('issue/'.$data);
				$result = $result["fields"]["issuetype"];
				break;
			default:
				$result = jira_get('issuetype');
		}
		return $result;
	}
#
##################################################################################
?>
