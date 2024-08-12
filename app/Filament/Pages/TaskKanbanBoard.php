<?php

namespace App\Filament\Pages;

use App\Models\Task;
use App\Enums\TaskStatus;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\MultiSelect;
use Mokhosh\FilamentKanban\Pages\KanbanBoard;
use Yepsua\Filament\Forms\Components\RangeSlider;

class TaskKanbanBoard extends KanbanBoard
{
    protected static string $model = Task::class;
    protected static string $statusEnum = TaskStatus::class;

    protected static ?string $navigationIcon = 'heroicon-o-check-circle';

    protected static string $recordTitleAttribute = 'title';

    protected function getEditModalFormSchema(null|int $recordId): array
    {
        return [
            TextInput::make('title')
            ->label('Title')->maxLength(25)->rules('required'),
            Textarea::make('description'),
            RangeSlider::make('progress')->steps([
                0 => "0",
                25 => "25",
                50 => "50",
                75 => "75",
                100 => "100"
            ])->step(25)->default(0),
            RangeSlider::make('urgent')->steps([
                0 => "0",
                1 => "1",
                2 => "2",
                3 => "3",
            ])->step(1)->default(0),
            TextInput::make('order_column')->numeric(),
            MultiSelect::make('users')->relationship('users','name')->label('Assign To Users')

        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
            ->model(Task::class)
            ->form([
                TextInput::make('title')->maxLength(25)->rules('required'),
                Textarea::make('description'),
                RangeSlider::make('progress')->steps([
                    0 => "0",
                    25 => "25",
                    50 => "50",
                    75 => "75",
                    100 => "100"
                ])->step(25)->default(0),
                RangeSlider::make('urgent')->steps([
                    0 => "0",
                    1 => "1",
                    2 => "2",
                    3 => "3",
                ])->step(1)->default(0),
                TextInput::make('order_column')->label('Order')->numeric(),
                MultiSelect::make('users')->relationship('users','name')->label('Assign To Users')
            ])->mutateFormDataUsing(function($data){
                $data['user_id'] = auth()->id();
                return $data;
            })
        ];
    }
}
