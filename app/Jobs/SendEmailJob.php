<?php

namespace App\Jobs;

use App\Models\Order;
use App\Mail\OrderNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class SendEmailJob implements ShouldQueue
{
    use Queueable,Dispatchable, SerializesModels;

    protected Order $order;
    /**
     * Create a new job instance.
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
        try {
            Mail::to($this->order->user->email)
                ->send(new OrderNotification($this->order));
    
            Log::info("SendEmailJob: Gửi thành công đến {$this->order->user->email}");
        } catch (\Throwable $e) {
            Log::error("SendEmailJob: Lỗi khi gửi mail - {$e->getMessage()}");
            // Nếu muốn job tiếp tục retry, throw lại
            throw $e;
        }
    }
}
