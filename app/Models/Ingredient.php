<?php
namespace App\Models;

use App\Mail\LowStockAlert;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;

/**
 * @property int $id
 * @property string $name
 * @property int $stock
 * @property int $initial_stock
 * @property int $alert_sent
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class Ingredient extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'stock', 'initial_stock', 'alert_sent'];

    protected $casts = [
        'alert_sent' => 'boolean',
    ];
}
