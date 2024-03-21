<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Upload extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'file_name',
        'file_path',
        'file_size',
        'uploaded_by',
        'is_excel_processed'
    ];
    
    
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}
