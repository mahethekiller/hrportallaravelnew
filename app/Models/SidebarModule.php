<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SidebarModule extends Model
{
    protected $table = 'sidebar_modules';

    protected $fillable = [
        'name', 'slug', 'icon', 'route', 'active_match',
        'section', 'sort_order', 'is_active', 'is_external'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_external' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function roles()
    {
        return $this->belongsToMany(
            \Spatie\Permission\Models\Role::class,
            'role_sidebar_modules',
            'sidebar_module_id',
            'role_id'
        );
    }
}
