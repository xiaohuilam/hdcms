<?php

namespace App;

use App\Models\Attachment;
use App\Models\Group;
use App\Models\Site;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'site_id',
        'name',
        'email',
        'password',
        'mobile',
        'email_verified_at',
        'token',
        'mobile_verified_at',
        'icon',
        'weibo',
        'wechat',
        'github',
        'qq',
        'admin_end',
        'lock',
        'group_id',
        'real_name',
    ];
    protected $casts = ['lock' => 'boolean', 'admin_end' => 'datetime'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function getAvatarAttribute()
    {
        return $this['icon'] ?? asset('images/user.jpg');
    }

    /**
     * 会员组关联
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    /**
     * 附件关联
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function attachment()
    {
        return $this->hasMany(Attachment::class);
    }

    /**
     * 超级管理员
     * @return bool
     */
    public function isSuperAdmin()
    {
        return $this['id'] == 1;
    }

    /**
     * 用户可以使用的站点列表
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function sites()
    {
        return $this->belongsToMany(Site::class)->as('role')
            ->withPivot('role')->withTimestamps();
    }
    /**
     * 当前用户所在站点
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
//    public function site()
//    {
//        return $this->belongsTo(Site::class,'site_id');
//    }
}
