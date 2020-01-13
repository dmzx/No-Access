<?php
/**
 *
 * @package phpBB Extension - No Access
 * @copyright (c) 2020 dmzx - https://www.dmzx-web.net
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace dmzx\noaccess\migrations;

use phpbb\db\migration\migration;

class noaccess_v101 extends migration
{
	static public function depends_on()
	{
		return [
			'\dmzx\noaccess\migrations\release_1_0_0',
		];
	}

	public function update_data()
	{
		return [
			['config.update', ['dmzx_noaccess_version', '1.0.1']],
		];
	}
}
