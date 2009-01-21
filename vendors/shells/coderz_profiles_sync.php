<?php
/**
 * Coderz Profiles Sync
 * 
 * Synchronises UserProfile fields with User database informations
 *
 *
 */
/**
 * Shell for Coderz Profiles sync
 *
 * @package    cake
 * @subpackage  cake.cake.console.libs
 */
class CoderzProfilesSyncShell extends Shell {
	
	
	var $uses = array('UserProfile', 'User', 'News');
	
/**
 * Fields to sync
 * They should be identical in the two tables
 */	
	var $syncFields = array('username', 'password', 'email');
	
/**
 * Contains arguments parsed from the command line.
 *
 * @var array
 * @access public
 */
	var $args;
	
/**
 * Override main() for help message hook
 *
 * @access public
 */
	function main() {
		$out  = __("Available Coderz Profiles sync commands:", true) . "\n";
		$out .= "\t - sync\n";
		$out .= "\t - report\n";
		$out .= "\t - news_slugs_sync\n";
		$out .= "\t - help\n\n";
		$out .= __("For help, run the 'help' command.  For help on a specific command, run 'help <command>'", true);
		$this->out($out);
	}


/**
 * Show help screen.
 *
 * @access public
 */
	function help() {
		$head  = __("Usage: cake acl_extras <command>", true) . "\n";
		$head .= "-----------------------------------------------\n";
		$head .= __("Commands:", true) . "\n\n";

		$commands = array(
			'sync' => "\tcake coderz_profiles_sync sync\n" .
			"\t\t" . __("Synchronize UserProfile table", true) . "\n" . 
			"\t\t" . __("Will only synch linked (profiles with a valid user)", true) . "\n" .
			"\t\t" . __("Will unlink non-existant user's profiles", true), 

			'report' =>  "\tcake coderz_profiles_sync report\n" . 
			"\t\t" . __("Reports unsynched linked UserProfiles and some other reports (see output)", true),
			
			'news_slugs_sync' => "\tcake coderz_profiles_sync news_slugs_sync\n" .
			"\t\t" . __('Create slugs for all news in database', true),

			'help' =>   "\thelp [<command>]\n" .
			"\t\t" . __("Displays this help message, or a message on a specific command.", true) . "\n"
			);

		$this->out($head);
		if (!isset($this->args[0])) {
			foreach ($commands as $cmd) {
				$this->out("{$cmd}\n\n");
			}
		} elseif (isset($commands[low($this->args[0])])) {
			$this->out($commands[low($this->args[0])] . "\n");
		} else {
			$this->out(sprintf(__("Command '%s' not found", true), $this->args[0]));
		}
	}
	
/**
 * Create slugs for news
 */
	function news_slugs_sync() {
		$i = $this->News->createAllPermalinks();
		if($i === false) {
			$this->out(__('Something went wrong !', true));
		}
		else {
			$this->out(sprintf(__("%d slugs created", true), $i));
		}
	}
	
	
/**
 * Sync profiles
 */
	function sync() {
		
		/* Find profiles without user */
		$this->UserProfile->contain('User');
		$c = $this->UserProfile->find('count', array('conditions' => array('AND' => array(
																						'User.id' => null, /* Delink/deactivate profiles without users ... */
																						array('OR' => array('UserProfile.user_id >' => 0, 'UserProfile.active' => 1)) /* ... which are either linked or active */
																						)
																			)
													)
									);
		$this->out(sprintf(__('Unlinking and deactivating %d mislinked or misactivated UserProfiles (users del )...', true), $c));
		$this->UserProfile->contain('User');
		$this->UserProfile->updateAll(	array('user_id' => 0, 'active' => 0, 'synched' => 'NOW()'), 
										array('AND' => array(
															'User.id' => null, /* Delink/deactivate profiles without users ... */
															array('OR' => array('UserProfile.user_id >' => 0, 'UserProfile.active' => 1)) /* ... which are either linked or active */
															)
												)
									);
		$this->out(__('Done !', true));
		
		
		/* Find users with profile */
		$this->User->contain(array('UserProfile'));
		$users = $this->User->find('all', array('conditions' => array('NOT' => array('UserProfile.id' => null)))); /* Find users with profiles */
		$this->out(sprintf(__('Checking %d users for sync ...', true), count($users)));
		$synched = 0;
		$failed = 0;
		foreach($users as $User) {
			$data = array();
			if($User['UserProfile']['active'] === 0) { /* active them */
				$data['active'] = 1;
			}
			if($User['User']['username'] != $User['UserProfile']['username']) {
				$data['username'] = $User['User']['username']; /* and synch them */
			}
			if($User['User']['password'] != $User['UserProfile']['password']) {
				$data['password'] = $User['User']['password'];
			}
			if($User['User']['mail'] != $User['UserProfile']['mail']) {
				$data['mail'] = $User['User']['mail'];
			}
			if(!empty($data)) {
				$data['synched'] = date('Y-m-d H:i:s');
				$this->UserProfile->id = $User['UserProfile']['id'];
				if($this->UserProfile->save(array('UserProfile' => $data), false) == true) {
					$this->out(sprintf(__('User %d:%s synched (%s)', true), $User['User']['id'], $User['User']['username'], implode(', ', array_keys($data))));
					$synched++;
				}
				else {
					$this->out(sprintf(__('User %d:%s sync failure !', true), $User['User']['id'], $User['User']['username']));
					$failed++;
				}
			}
		}
		$this->out(sprintf(__('Synchro (hopefully) complete : %d synched, %d failed, %d ignored', true), $synched, $failed, count($users) - $synched - $failed));
		
		

		
	}
/**
 * Report unsynched linked profiles
 */
	function report() {
		
		/* Count users without a profile */
		$this->User->contain('UserProfile');
		$users = $this->User->find('all');
		$c_all = count($users);
		$c = 0;
		
		foreach($users as $User) {
			if(is_numeric($User['UserProfile']['id'])) {
				$c++;
			}
		}
		$this->out(sprintf(__('Users with profile : %d/%d (%01.2f%%)', true), $c, $c_all, 100*$c/$c_all));
		
		/* Count inactive profiles */
		$this->UserProfile->contain(array());
		$c = $this->UserProfile->find('count', array('conditions' => array('UserProfile.active' => 0)));
		$c_all = $this->UserProfile->find('count');
		$this->out(sprintf(__('Inactive profiles : %d/%d (%01.2f%%)', true), $c, $c_all, 100*$c/$c_all));
		
		/* Lookup active profiles with deleted (UserProfile.user_id = 0) user */
		$this->UserProfile->contain(array('User'));
		$profiles = $this->UserProfile->find('all', array('conditions' => array('UserProfile.active' => 1)));
		$this->out("\n". __('Looking up orphan active profiles which should be deactivated ...', true));
		$c = 0;
		$c_all = $this->UserProfile->find('count', array('conditions' => array('UserProfile.active' => 1)));
		
		foreach($profiles as $Profile) {
			if(!is_numeric($Profile['User']['id'])) { /* User not found */
				$this->out(sprintf(__('Profile %d (%s/%s) is orphan, user purged ?', true), $Profile['UserProfile']['id'], $Profile['UserProfile']['username'], $Profile['UserProfile']['mail']));
				$c++;
			}
		}
		$this->out(sprintf(__('Total orphan profiles : %d/%d (%01.2f%%)', true), $c, $c_all, 100*$c/$c_all));
		
		/* Lookup some weird stuff (unactive profiles with linked User) */
		
		$this->User->contain('UserProfile');
		$users = $this->User->find('all', array('conditions' => array('UserProfile.active' => 0)));
		
		$this->out("\n". __('Looking up users with a deactivated profile', true));
		foreach($users as $User) {
			$this->out(sprintf(__('User %d:%s has a deactivated profile, WTF ?', true), $User['User']['id'], $User['User']['username']));
		}
		
		/* Lookup desynched profiles (profile active or not) */
		$this->out("\n". __('Looking up desynched profiles', true));
		$this->User->contain(array('UserProfile'));
		
		$users = $this->User->find('all', array('conditions' => array('NOT' => array('UserProfile.id' => 0)))); /* Find users with profiles */
		foreach($users as $User) {
 			$desynch = array();
			if($User['User']['username'] != $User['UserProfile']['username']) {
				$desynch[] = 'username';
			}
			if($User['User']['password'] != $User['UserProfile']['password']) {
				$desynch[] = 'password';
			}
			if($User['User']['mail'] != $User['UserProfile']['mail']) {
				$desynch[] = 'mail';
			}
			if(!empty($desynch)) {
				$this->out(sprintf(__('User %d:%s desynched (%s)', true), $User['User']['id'], $User['User']['username'], implode(', ', $desynch)));
			}
		}

		$this->out("\n". __('All done !', true));
		
	}

}
?>