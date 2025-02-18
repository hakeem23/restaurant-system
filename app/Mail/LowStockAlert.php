<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Ingredient;

class LowStockAlert extends Mailable
{
    use Queueable, SerializesModels;

    public $ingredient;

    public function __construct(Ingredient $ingredient)
    {
        $this->ingredient = $ingredient;
    }

    public function build()
    {
        return $this->subject("⚠️ Low Stock Alert: {$this->ingredient->name}")
            ->view('emails.low_stock_alert')
            ->with(['ingredient' => $this->ingredient]);
    }
}
