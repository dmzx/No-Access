<?php
/**
*
* @package phpBB Extension - No Access
* @copyright (c) 2017 dmzx - https://www.dmzx-web.net
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace dmzx\noaccess\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use phpbb\config\config;
use phpbb\user;
use phpbb\auth\auth;

class listener implements EventSubscriberInterface
{
	/* @var config */
	protected $config;

	/* @var user */
	protected $user;

	/* @var auth */
	protected $auth;

	/**
	* Constructor
	*
	* @param config		$config
	* @param user		$user
	* @param auth		$auth
	*/
	public function __construct(
		config $config,
		user $user,
		auth $auth
	)
	{
		$this->config = $config;
		$this->user = $user;
		$this->auth = $auth;
	}

	static public function getSubscribedEvents()
	{
		return array(
			'core.display_forums_modify_template_vars'	=> 'display_forums_modify_template_vars',
		);
	}

	public function display_forums_modify_template_vars($event)
	{
		$forum_row = $event['forum_row'];
		$row = $event['row'];

		if (!$this->auth->acl_get('f_read', $row['forum_id']))
		{
			$this->user->add_lang_ext('dmzx/noaccess', 'common');

			$forum_row['TOPICS'] = '-';
			$forum_row['POSTS'] = '-';
			$forum_row['LAST_POST_TIME'] = '<script>
				var script = document.currentScript || (function() {
					var scripts = document.getElementsByTagName("script");
					return scripts[scripts.length - 1];
				})();
				script.parentNode.parentNode.innerHTML = "<span><b><i>' . $this->user->lang['NOACCESS_TEXT'] . '</i></b></span>";
			</script>
			';
		}
		$event['forum_row'] = $forum_row;
	}
}
