<?php

namespace Modules\Diskominfo\Models;

use Illuminate\Database\Eloquent\Model;

class DiskominfoUser extends Model
{
    protected $connection = 'diskominfo';

    protected $table = 'diskominfo_users';

    protected $guarded = [];

    protected $hidden = [
        'password',
    ];

    /**
     * Verifikasi password pengguna admin Diskominfo.
     */
    public function verifyPassword(string $plainPassword): bool
    {
        return password_verify($plainPassword, $this->password);
    }

    /**
     * Hash password otomatis jika diset.
     */
    public function setPasswordAttribute(string $value): void
    {
        $this->attributes['password'] = password_needs_rehash($value, PASSWORD_BCRYPT)
            ? password_hash($value, PASSWORD_BCRYPT)
            : $value;
    }

    /**
     * Render badge peran (role).
     */
    public function getRoleBadge(): string
    {
        return match ($this->role) {
            'superadmin'      => '<span class="badge-pill badge-rose"><i class="fa-solid fa-shield"></i> SUPER ADMIN</span>',
            'operator_sla'    => '<span class="badge-pill badge-cyan"><i class="fa-solid fa-server"></i> OPERATOR SLA</span>',
            'pimpinan_daerah' => '<span class="badge-pill badge-amber"><i class="fa-solid fa-user-tie"></i> PIMPINAN DAERAH</span>',
            default           => '<span class="badge-pill badge-blue">STAFF DISKOMINFO</span>',
        };
    }
}
