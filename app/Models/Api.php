<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Api extends Model
{
    use HasFactory;
    protected $table = 'api';
    protected $fillable =['sg_agent_code', 
    'sg_sign', 
    'sg_endpoint',
    'nx_agent_code',
    'nx_token',
    'nx_endpoint',
    'wsg_agent_code',
    'wsg_token',
    'wsg_endpoint',
    'ng_agent_code',
    'ng_signature',
    'ng_endpoint',
    'sg_status',
    'nx_status',
    'ng_status',
    'wsg_status'];
}
