<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class GenerateMusicianAvatars extends Command
{
    protected $signature = 'musicians:generate-avatars';
    protected $description = 'Генерирует аватары для всех музыкантов';

    public function handle()
    {
        $this->info('Начинаем генерацию аватаров...');

        $musicians = User::where('role', 'musician')->get();
        $bar = $this->output->createProgressBar(count($musicians));

        foreach ($musicians as $musician) {
            if (!$musician->avatar) {
                try {
                    // Генерируем случайный аватар
                    $avatarUrl = "https://api.dicebear.com/7.x/avataaars/svg?seed=" . urlencode($musician->name);
                    $avatarContent = file_get_contents($avatarUrl);
                    
                    // Сохраняем аватар
                    $avatarPath = 'avatars/' . $musician->id . '.svg';
                    Storage::disk('public')->put($avatarPath, $avatarContent);
                    
                    // Обновляем пользователя
                    $musician->update(['avatar' => $avatarPath]);
                    
                    $this->info("\nСгенерирован аватар для {$musician->name}");
                } catch (\Exception $e) {
                    $this->error("\nОшибка при генерации аватара для {$musician->name}: {$e->getMessage()}");
                }
            }
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info('Генерация аватаров завершена!');
    }
} 