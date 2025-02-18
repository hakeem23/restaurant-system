<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use App\Repositories\IngredientRepository;
use App\Models\Ingredient;
use App\Mail\LowStockAlert;
use PHPUnit\Framework\Attributes\Test;

class IngredientRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected $ingredientRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->ingredientRepository = new IngredientRepository();
    }

    #[Test]
    public function it_updates_stock_correctly()
    {
        $ingredient = Ingredient::factory()->create(['stock' => 100]);

        $result = $this->ingredientRepository->updateStock($ingredient, 30);

        $this->assertTrue($result);
        $this->assertEquals(70, $ingredient->fresh()->stock);
    }

    #[Test]
    public function it_sends_low_stock_alert_when_stock_reaches_threshold()
    {
        Mail::fake(); // Prevent actual email sending

        $ingredient = Ingredient::factory()->create([
            'stock' => 51,
            'initial_stock' => 200,
            'alert_sent' => false
        ]);

        $this->ingredientRepository->deductStock($ingredient, 10);

        Mail::assertSent(LowStockAlert::class, function ($mail) use ($ingredient) {
            return $mail->ingredient->id === $ingredient->id;
        });

        $this->assertTrue($ingredient->fresh()->alert_sent);
    }

    #[Test]
    public function it_does_not_send_alert_if_already_sent()
    {
        Mail::fake();

        $ingredient = Ingredient::factory()->create([
            'stock' => 30,
            'initial_stock' => 200,
            'alert_sent' => true
        ]);

        $this->ingredientRepository->deductStock($ingredient, 10);

        Mail::assertNothingSent();
    }

    #[Test]
    public function it_deducts_stock_and_triggers_low_stock_alert()
    {
        Mail::fake();

        $ingredient = Ingredient::factory()->create([
            'stock' => 55,
            'alert_sent' => false
        ]);

        $this->ingredientRepository->deductStock($ingredient, 30);

        $this->assertEquals(25, $ingredient->fresh()->stock);

        Mail::assertSent(LowStockAlert::class);
        $this->assertTrue($ingredient->fresh()->alert_sent);
    }
}
