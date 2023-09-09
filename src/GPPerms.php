<?php
namespace GPPerms;
use Illuminate\Database\Eloquent\Model;
use GPRanks;
class GPPerms extends Model {
	protected $table = 'gpperms_users';
    public $incrementing = false;
	public $timestamps = false;
	protected $guarded = [];

	// GPPerms::CanRank(Auth::id(), $rank_name);
	public static function CanRank($userid, $rankname): bool
	{
		$rank_id = GPRanks::GetRankID($rankname);
		if ($u = self::where('user_id', $userid)->first()) {
			if ($u->rank_id == $rank_id) {
				return true;
			}
		}
		return false;
	}
	// GPPerms::Add($user_id, 'Rank Name or ID');
	public static function Add($user_id, $rank): string
	{
		if (is_string($rank)) {
			$rank = GPRanks::GetRankID($rankname);
		}
		if ($ur = self::where('user_id', $user_id)->first()) {
			return "User already added. Please use Update method instead";
		}else{
			self::insert(['user_id' => $user_id, 'rank_id' => $rank, 'added' => time()]);
			return "User added with rank ID ".$rank;
		}
		return "Adding derp";
	}
	// GPPerms::Update($user_id, 'Rank Name or ID');
	public static function Update($user_id, $rank): string
	{
		if (is_string($rank)) {
			$rank = GPRanks::GetRankID($rankname);
		}
		if ($ur = self::where('user_id', $user_id)->first()) {
			self::where('user_id', $user_id)->update(['rank_id' => $rank, 'changed' => time()]);
			return "User rank changed";
		}else{
			return "User Not found. Please use the Add method";
		}
		return "Updating derp";
	}
}