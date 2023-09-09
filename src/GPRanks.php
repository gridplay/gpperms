<?php
namespace GPPerms;
use Illuminate\Database\Eloquent\Model;
class GPRanks extends Model {
	protected $table = 'gpperms_ranks';
    public $incrementing = true;
	public $timestamps = false;
	protected $guarded = [];
	// converts rank name to id
	public static function GetRankID($rankname): integer
	{
		if ($r = self::where('rank_name', $rankname)->first()) {
			return $r->rank_id;
		}
		return -1;
	}
	// GPRanks::AddorUpdateRankName($rank_name, $optional_id);
	// $optional_id is ONLY for updating $rank_name
	public static function AddorUpdateRankName($rname, $rid = 0): integer
	{
		if ($r = self::where('rank_id', $rid)->first()) {
			self::where('rank_id', $rid)->update(['rank_name' => $rname]);
			return $rid;
		}else{
			return self::insertGetId(['rank_name' => $rname]);
		}
	}
}