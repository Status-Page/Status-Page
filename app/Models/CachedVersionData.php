<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CachedVersionData extends Model
{
    use HasFactory;

    public static function getEntry(): CachedVersionData{
        return CachedVersionData::query()->get()->first();
    }

    public function getLatestVersion(): string {
        return $this->latest_version_from_github;
    }

    public function setLatestVersion(string $version){
        $this->latest_version_from_github = $version;
        $this->save();
    }
}
