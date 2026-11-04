<?php
namespace Modules\Core\Models; use Illuminate\Database\Eloquent\Model; use Illuminate\Database\Eloquent\Relations\BelongsTo; class Alumno extends Model { protected $fillable=['user_id','matricula']; public function user(): BelongsTo { return $this->belongsTo(\App\Models\User::class); } }
