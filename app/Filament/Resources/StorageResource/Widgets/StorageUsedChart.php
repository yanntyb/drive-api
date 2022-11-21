<?php

namespace App\Filament\Resources\StorageResource\Widgets;

use App\Models\Storage\Storage;
use Filament\Widgets\DoughnutChartWidget;
use StorageService;

class StorageUsedChart extends DoughnutChartWidget
{
    public ?Storage $record = null;
    protected int | string | array $columnSpan = 'full';
    protected static ?string $maxHeight = '15vh';
    protected static ?string $pollingInterval = null;
    protected static ?array $options = [
        "rotation" => -90,
        "circumference" => 180,
        "elements" => [
            "arc" => [
                "borderWidth" => 0
            ]
        ],
        'plugins' => [
            'legend' => [
                'display' => false,
            ],
        ],
    ];
    protected float $used;
    protected float $free;

    protected function getHeading(): ?string
    {
        return StorageService::getDirectoryUsedSized($this->record) / 1000000 . " mo / " . $this->record->size . " mo";
    }

    protected function getData(): array
    {
        return [
            "datasets" => [[
                "label" => "Storage used",
                "data" => [StorageService::getDirectoryUsedSized($this->record) / 1000000 ,$this->record->size],
                "backgroundColor" => [
                    "#E74C3C",
                    "#82E0AA",
                ],
            ]],
            "labels" => ["used","free"]
        ];
    }

}
