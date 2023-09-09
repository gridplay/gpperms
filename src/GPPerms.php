<?php
namespace GPPerms;
use Illuminate\Database\Eloquent\Model;
use GPRanks;
class GPPerms extends Model {
	protected $table = 'gpperms_users';
    public $incrementing = false;
	public $timestamps = false;
	protected $guarded = [];

	// GPPerms::Can(Auth::id(), $rank_name);
	public static function Can($userid, $rankname): bool
	{
		$rank_id = GPRanks::GetRankID($rankname);
		if ($u = self::where('user_id', $userid)->first()) {
			if ($u->rank_id == $rank_id) {
				return true;
			}
		}
		return false;
	}
}