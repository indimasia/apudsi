<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $fillable = [
        'group_id',
        'sent_by',
        'message',
        'attachment',
    ];

    protected $appends = [
        'attachment_path',
    ];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function sentBy() {
        return $this->belongsTo(User::class, 'sent_by');
    }

    public function getAttachmentPathAttribute() {
        return $this->attachment ? asset('storage/' . $this->attachment) : null;
    }

    public function member() {
        return $this->hasOne(GroupMember::class, 'group_id', 'group_id');
    }
}
