<?php

namespace App\Console\Commands;

use App\Services\Settings\SettingsService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Output\ConsoleOutput;

class CacheSettings extends Command
{
    protected $signature = 'settings:cache
                            {--c|clear : Clear the settings cache before caching again}
                            {--d|display : Display the cached settings after caching}';

    protected $description = 'Cache the application settings';

    protected $settingsService;

    public function __construct(SettingsService $settingsService)
    {
        parent::__construct();
        $this->settingsService = $settingsService;
    }

    public function handle()
    {
        try {
            if ($this->option('clear')) {
                Cache::forget('settings');
                $this->info('Settings cache cleared.');
            }

            if (!$this->option('display')) {
                // Only cache settings if --display is not set
                $this->settingsService->cacheSettings();
                $this->comment("<fg=green;options=bold> Settings have been cached.</>");
            }

            if ($this->option('display')) {
                $settings = Cache::get('settings');
                if ($settings === null) {
                    $this->error('No settings found in cache. Please cache settings first.');
                } else {
                    $this->displayBlinkingMessage('Display list of settings');
                    $this->displaySettings($settings);
                }
            }
        } catch (\Exception $e) {
            $this->error('An error occurred while caching settings: ' . $e->getMessage());
        }
    }
    protected function displayBlinkingMessage(string $message)
    {
        // Output some spacing before the blinking message
        $this->line('');

        // Display blinking message
        $this->comment("<fg=green;options=bold,blink> {$message}</>");

        // Output some spacing after the blinking message

        $this->line('');
    }
    protected function displaySettings(array $settings)
    {
        $output = new ConsoleOutput();
        $table = new Table($output);

        $table->setHeaders(['<fg=green;options=bold>Key</>', '<fg=yellow;options=bold>Value</>']);

        foreach ($settings as $key => $value) {
            $table->addRow([
                "<fg=green>{$key}</>",
                "<fg=yellow>{$value}</>"
            ]);
        }

        $table->setStyle('box');
        $table->render();
    }
}
