<?php
namespace GPPerms;
use Illuminate\Database\Eloquent\Model;
use GPRanks;
class GPPerms extends Model {
	protected $table = 'gpperms_users';
    public $incrementing = false;
	public $timestamps = false;
	protected $guarded = [];

	// GPPerms::CanRank(Auth::id(), 'Rank name or ID');
	public static function CanRank($userid, $rank): bool
	{
		if (is_string($rank)) {
			$rank = GPRanks::GetRankID($rank);
		}
		if ($u = self::where('user_id', $userid)->first()) {
			if ($u->rank_id == $rank) {
				return true;
			}
		}
		return false;
	}
	// GPPerms::AddorUpdateUser($user_id, 'Rank Name or ID');
	public static function AddorUpdateUser($user_id, $rank): string
	{
		if (is_string($rank)) {
			$rank = GPRanks::GetRankID($rank);
		}
		if ($ur = self::where('user_id', $user_id)->first()) {
			self::where('user_id', $user_id)->update(['rank_id' => $rank, 'changed' => time()]);
			return "User already added, updated rank instead";
		}else{
			self::insert(['user_id' => $user_id, 'rank_id' => $rank, 'added' => time()]);
			return "User added with rank ID ".$rank;
		}
		return "Adding/Updating derp";
	}
}