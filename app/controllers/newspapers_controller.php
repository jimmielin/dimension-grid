<?php
/**
 * Dimension.Grid
 * @author    Jimmie Lin <jimmie.lin@gmail.com>
 * @since     1.0.600.1
 * @license   Dimension.Grid Developer Non-Disclosure Agreement
 * @copyright (c) 2010 Jimmie Lin
 */

class NewspapersController extends AppController {
	var $name = "Newspapers";
	var $helpers = array('decoda');
	var $uses = array("Newspaper", "Newspaper_comment"); // TODO Remove this, performance lag

	function index() {
		$this->redirect(array('controller' => 'dashboard', 'action' => 'index'));
		exit;
	}

	function view() {
		$Args = func_get_args();
		if(count($Args) != 1) {
			$this->redirect(array('controller' => 'dashboard', 'action' => 'index'));
			exit;
		}
		$ID = intval($Args[0]);
		$this->set("ID", $ID);

		if(($Data = Cache::read("newspaper_raw_$ID")) === false) {
			$Data = $this->Newspaper->find(
				"first",
				array(
					"conditions" => array(array("Newspaper.id" => $ID)),
					"contain" => array(
						"User",
						"Country"
					)
				)
			);

			if(!$Data) {
				$this->redirect(array('controller' => 'dashboard', 'action' => 'index'));
				exit;
			}

			Cache::write("newspaper_raw_$ID", $Data, "long");
		}

		$this->set("data", $Data);

		// Now paginate the articles.
		$this->paginate = array(
			"conditions" => array("Newspaper_article.newspaper_id" => $ID),
			"limit" => 10,
			"order" => "Newspaper_article.date DESC",
			"contain" => array(
				"Newspaper_comment"
			)
		);

		$adata = $this->paginate("Newspaper_article");
		$this->set("articles", $adata);
	}

	function article() {
		// view an independent article, by it's id
		$Args = func_get_args();
		if(count($Args) < 1) {
			$this->redirect(array('controller' => 'dashboard', 'action' => 'index'));
			exit;
		}

		$ID = intval($Args[0]);
		$Article = $this->Newspaper->Newspaper_article->find('first', array('conditions' => array("Newspaper_article.id" => $ID), 'contain' => "Newspaper.User"));
		if(!$Article) {
			$this->redirect(array('controller' => 'dashboard', 'action' => 'index'));
			exit;
		}

		$this->set("Article", $Article);

		// Fetch the comments related, and remember to paginate. Ugh.
		$this->paginate = array(
			"conditions" => array("Newspaper_comment.newspaper_article_id" => $ID),
			"limit" => 25,
			"order" => "Newspaper_comment.date DESC",
			"contain" => array(
				"User"
			)
		);

		$commentData = $this->paginate("Newspaper_comment");
		$this->set("comments", $commentData);
	}

	function trust() {}
	
	function edit() {
		$userdata = $this->Userdata->getUserDataById($this->Auth->user("id"));
		if(!$userdata["Newspaper"]["id"]) {
			$this->redirect(array("controller" => "newspapers", "action" => "create"));
			exit;
		}
		
		// This only has a control for editing the newspaper name, anyway... erm.
		if(!empty($this->data)) {
			$Args = func_get_args();
			// Start CSRF Verification
			// CSRF token?
			if(!$this->Session->read("System.csrf_token") or !isset($Args[0])) {
				$this->redirect(array('controller' => 'dashboard', 'action' => 'index'));
				exit;
			}
			
				if($this->Session->read("System.csrf_token") != $Args[0]) {
					$this->redirect(array('controller' => 'dashboard', 'action' => 'index'));
					exit;
				}

			// remove the previous CSRF token
			$this->Session->delete("System.csrf_token");
			// END CSRF Verification
		
			if(!isset($this->data["Newspaper"]["name"]) || empty($this->data["Newspaper"]["name"])) {
			   	$this->Session->setFlash(__("Your newspaper name cannot be empty!", true), "flash_failure");
				return;
			}
			
			
		}
	
	}

	function create() {
		$userdata = $this->Userdata->getUserDataById($this->Auth->user("id"));

		if($userdata["Newspaper"]["id"]) {
			$this->redirect(array("controller" => "newspapers", "action" => "view", $userdata["Newspaper"]["id"]));
			exit;
		}

		// OK, if there's input...
		if(!empty($this->data)) {
			$Args = func_get_args();
			// Start CSRF Verification
			// CSRF token?
			if(!$this->Session->read("System.csrf_token") or !isset($Args[0])) {
				$this->redirect(array('controller' => 'dashboard', 'action' => 'index'));
				exit;
			}
			
				if($this->Session->read("System.csrf_token") != $Args[0]) {
					$this->redirect(array('controller' => 'dashboard', 'action' => 'index'));
					exit;
				}

			// remove the previous CSRF token
			$this->Session->delete("System.csrf_token");
			// END CSRF Verification
		
			if(!isset($this->data["Newspaper"]["name"]) || empty($this->data["Newspaper"]["name"])) {
			   	$this->Session->setFlash(__("Your newspaper name cannot be empty!", true), "flash_failure");
				return;
			}

			$this->data["Newspaper"]["user_id"] = $userdata["User"]["id"];
			$this->data["Newspaper"]["country_id"] = $userdata["User"]["citizenship"];
			$InsertProcedure = $this->Newspaper->save($this->data, false, array("name", "user_id", "country_id"));

			if(!$InsertProcedure) {
				$this->Session->setFlash(__("Invalid data identifier", true), "flash_failure");
				return;
			}
			else {
				// Deduct Platinum!
				$this->Newspaper->User->deductPlatinum(2, $userdata["User"]["id"]);
				$this->flash(__("Your newspaper has been created successfully! You will now be redirected to it.", true), "/newspapers/own");
			}
		}
	}

	function write() {
		$userdata = $this->Userdata->getUserDataById($this->Auth->user("id"));
		if(!isset($userdata["Newspaper"])) {
			// present the newspaper creation screen!
			$this->redirect(array("controller" => "newspapers", "action" => "create"));
			exit;
		}

		// OK, if there's input...
		if(!empty($this->data)) {
			$Args = func_get_args();
			// Start CSRF Verification
			// CSRF token?
			if(!$this->Session->read("System.csrf_token") or !isset($Args[0])) {
				$this->redirect(array('controller' => 'dashboard', 'action' => 'index'));
				exit;
			}
			
				if($this->Session->read("System.csrf_token") != $Args[0]) {
					$this->redirect(array('controller' => 'dashboard', 'action' => 'index'));
					exit;
				}

			// remove the previous CSRF token
			$this->Session->delete("System.csrf_token");
			// END CSRF Verification

			if(!isset($this->data["Newspaper_article"]["title"]) || empty($this->data["Newspaper_article"]["title"]) || !isset($this->data["Newspaper_article"]["content"]) || empty($this->data["Newspaper_article"]["content"])) {
			   	$this->Session->setFlash(__("Invalid data identifier", true), "flash_failure");
				return;
			}

			$this->data["Newspaper_article"]["date"] = date("Y-m-d h:m:s");
			$this->data["Newspaper_article"]["newspaper_id"] = $userdata["Newspaper"]["id"];
			$InsertProcedure = $this->Newspaper->Newspaper_article->save($this->data, false, array("title", "content", "date", "newspaper_id"));

			if(!$InsertProcedure) {
				$this->Session->setFlash(__("Invalid data identifier", true), "flash_failure");
				return;
			}
			else {
				$this->flash(__("Your article is now published! Note that you may have to wait a few minutes before it is shown to public.", true), "/newspapers/own");
			}
		}
	}

	function vote() {
		$Args = func_get_args();
		if(count($Args) < 2) {
			$this->redirect(array("controller" => "dashboard", "action" => "index"));
			exit;
		}

		$voteID = intval($Args[0]);
		$voteAction = $Args[1];

		// Start CSRF Verification
		// CSRF token?
		if(!$this->Session->read("System.csrf_token") or !isset($Args[2])) {
			$this->redirect(array('controller' => 'dashboard', 'action' => 'index'));
			exit;
		}
		
			if($this->Session->read("System.csrf_token") != $Args[2]) {
				$this->redirect(array('controller' => 'dashboard', 'action' => 'index'));
				exit;
			}

		// remove the previous CSRF token
		$this->Session->delete("System.csrf_token");
		// END CSRF Verification

		$this->Newspaper->Newspaper_article->id = $voteID;
		$Article = $this->Newspaper->Newspaper_article->find('first', array('conditions' => array("Newspaper_article.id" => $voteID)));
		
		if(!$Article) {
			$this->redirect(array('controller' => 'dashboard', 'action' => 'index'));
			exit;
		}

		// Verify whether we have voted already or not

		if(!($this->Session->read("Newspaper.voted_".$voteID) == false)) {
			$this->redirect(array('controller' => 'newspapers', 'action' => 'view', $Article["Newspaper_article"]["newspaper_id"]));
		}

		if($voteAction == "up") {
			$newVoteNum = $Article["Newspaper_article"]["votes"] + 1;
			$this->Newspaper->Newspaper_article->saveField("votes", $newVoteNum);
		}

		if($voteAction == "down") {
			$newVoteNum = $Article["Newspaper_article"]["votes"] - 1;
			$this->Newspaper->Newspaper_article->saveField("votes", $newVoteNum);
		}

		$this->Session->write("Newspaper.voted_".$voteID, true);
		$this->redirect(array('controller' => 'newspapers', 'action' => 'view', $Article["Newspaper_article"]["newspaper_id"]));

		exit;
	}

	function delete() {
		$Args = func_get_args();
		if(count($Args) < 2) {
			$this->redirect(array("controller" => "dashboard", "action" => "index"));
			exit;
		}

		$ID = intval($Args[0]);

		// Start CSRF Verification
		// CSRF token?
		if(!$this->Session->read("System.csrf_token") or !isset($Args[1])) {
			$this->redirect(array('controller' => 'dashboard', 'action' => 'index'));
			exit;
		}
		
			if($this->Session->read("System.csrf_token") != $Args[1]) {
				$this->redirect(array('controller' => 'dashboard', 'action' => 'index'));
				exit;
			}

		// remove the previous CSRF token
		$this->Session->delete("System.csrf_token");
		// END CSRF Verification

		// Are you deleting your own newspaper's posts?
		$userdata = $this->Userdata->getUserDataById($this->Auth->user("id"));
		$article = $this->Newspaper->Newspaper_article->find('first', array('conditions' => array("Newspaper_article.id" => $ID)));
		if(!$article) {
			$this->redirect(array('controller' => 'dashboard', 'action' => 'index'));
			exit;
		}

		if((!isset($userdata["Newspaper"])) ||$article["Newspaper_article"]["newspaper_id"] != $userdata["Newspaper"]["id"]) {
			$this->redirect(array('controller' => 'dashboard', 'action' => 'index'));
			exit;
		}

		// finally, delete the post
		$this->Newspaper->Newspaper_article->delete($ID);
		$this->flash(__("Your newspaper article has been deleted successfully!", true), "/newspapers/view/".$userdata["Newspaper"]["id"]);
	}

	function own() {
		$userdata = $this->Userdata->getUserDataById($this->Auth->user("id"));

		if($userdata["Newspaper"]["id"]) {
			$this->redirect(array("controller" => "newspapers", "action" => "view", $userdata["Newspaper"]["id"]));
			exit;
		}
		else {
			// present the newspaper creation screen!
			$this->redirect(array("controller" => "newspapers", "action" => "create"));
			exit;
		}
	}
}