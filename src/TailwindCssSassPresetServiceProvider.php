<?php

namespace CarlosRE\LaravelPresetTailwindCssSass;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Console\PresetCommand;

class TailwindCssSassPresetServiceProvider extends ServiceProvider
{
	public function boot()
	{
		PresetCommand::macro('tailwindcss-sass', function ($command) {
			TailwindCssSassPreset::install();

			$command->info('Tailwind CSS & Sass scaffolding installed successfully.');
			$command->info('Please run "npm install && npm run dev" to compile your fresh scaffolding.');
		});
	}
}