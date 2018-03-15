<?php

namespace CarlosRE\LaravelPresetTailwindCssSass;

use Illuminate\Support\Arr;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Console\Presets\Preset;

class TailwindCssSassPreset extends Preset
{
	/**
	 * Install the preset.
	 *
	 * @return void
	 */
	public static function install()
	{
		static::updatePackages();
		static::updateSass();
		static::updateWebpackConfiguration();
		static::updateBootstrapping();
		static::removeNodeModules();
	}

	/**
	 * Update the given package array.
	 *
	 * @param  array  $packages
	 * @return array
	 */
	protected static function updatePackageArray(array $packages)
	{
		return [
			'tailwindcss' => '^0.5.1',
		] + Arr::except($packages, ['bootstrap-sass', 'jquery']);
	}

	/**
	 * Update the Sass files for the application.
	 *
	 * @return void
	 */
	protected static function updateSass()
	{
		(new Filesystem)->delete(public_path('css/app.css'));
		copy(__DIR__.'/tailwindcss-sass-stubs/resources/assets/sass/app.scss', resource_path('assets/sass/app.scss'));
	}

	/**
	 * Update the Webpack configuration.
	 *
	 * @return void
	 */
	protected static function updateWebpackConfiguration()
	{
		copy(__DIR__.'/tailwindcss-sass-stubs/webpack.mix.js', base_path('webpack.mix.js'));
	}

	/**
	 * Update the bootstrapping files.
	 *
	 * @return void
	 */
	protected static function updateBootstrapping()
	{
		copy(__DIR__.'/tailwindcss-sass-stubs/resources/assets/js/app.js', resource_path('assets/js/app.js'));
		copy(__DIR__.'/tailwindcss-sass-stubs/tailwind.js', base_path('tailwind.js'));
		copy(__DIR__.'/tailwindcss-sass-stubs/bootstrap.js', resource_path('assets/js/bootstrap.js'));
	}
}