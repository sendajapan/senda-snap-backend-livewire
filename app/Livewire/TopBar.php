<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Services\NoticeService;
use Livewire\Component;

class TopBar extends Component
{
    public string $currentTime = '';

    public string $currentDate = '';

    public ?string $tokyoTemperature = null;

    public function mount(NoticeService $noticeService): void
    {
        $this->updateDateTime();
        $this->fetchTokyoTemperature();
    }

    public function updateDateTime(): void
    {
        $now = now()->setTimezone('Asia/Tokyo');
        $this->currentTime = $now->format('H:i:s');
        $this->currentDate = $now->format('M d, Y');
    }

    public function fetchTokyoTemperature(): void
    {
        // For now, we'll use a placeholder or fetch from a weather API
        // You can integrate with OpenWeatherMap, WeatherAPI, etc.
        // For now, setting to null - will be implemented with API call
        $this->tokyoTemperature = null;
    }

    public function render(NoticeService $noticeService)
    {
        $notices = $noticeService->getActiveNotices();

        return view('livewire.top-bar', [
            'notices' => $notices,
        ]);
    }
}
