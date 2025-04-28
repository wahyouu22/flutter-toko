<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Produk;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HistoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_can_view_order_history()
    {
        $user = User::factory()->create(['role' => 2]);
        $order = Order::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)
                         ->get(route('history.index'));

        $response->assertStatus(200);
        $response->assertSee($order->id);
    }

    public function test_customer_can_view_order_detail()
    {
        $user = User::factory()->create(['role' => 2]);
        $order = Order::factory()->create(['user_id' => $user->id]);
        $product = Produk::factory()->create();
        OrderItem::factory()->create([
            'order_id' => $order->id,
            'product_id' => $product->id
        ]);

        $response = $this->actingAs($user)
                         ->get(route('history.show', $order->id));

        $response->assertStatus(200);
        $response->assertSee($product->nama_produk);
    }

    public function test_customer_can_update_order_address()
    {
        $user = User::factory()->create(['role' => 2]);
        $order = Order::factory()->create([
            'user_id' => $user->id,
            'status' => 'pending'
        ]);

        $response = $this->actingAs($user)
                         ->put(route('history.update', $order->id), [
                             'alamat' => 'Alamat Baru',
                             'pos' => '12345',
                             'hp' => '08123456789'
                         ]);

        $response->assertRedirect(route('history.show', $order->id));
        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'alamat' => 'Alamat Baru'
        ]);
    }

    public function test_customer_can_download_invoice()
    {
        $user = User::factory()->create(['role' => 2]);
        $order = Order::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)
                         ->get(route('history.invoice.download', $order->id));

        $response->assertStatus(200);
        $response->assertHeader('Content-Disposition');
    }
}
