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
			'tailwindcss' => '^0.6.5',
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
		copy(__DIR__.'/tailwindcss-sass-stubs/resources/sass/app.scss', self::getResourcePath('sass/app.scss'));
	}

	/**
	 * Update the Webpack configuration.
	 *
	 * @return void
	 */
	protected static function updateWebpackConfiguration()
	{
		if (version_compare(app()->version(), '5.7.0', '>=')) {
			copy(__DIR__.'/tailwindcss-sass-stubs/webpack.mix.js', base_path('webpack.mix.js'));
		} else {
			copy(__DIR__.'/tailwindcss-sass-stubs/webpack.old.mix.js', base_path('webpack.mix.js'));
		}
	}

	/**
	 * Update the bootstrapping files.
	 *
	 * @return void
	 */
	protected static function updateBootstrapping()
	{
		copy(__DIR__.'/tailwindcss-sass-stubs/resources/js/app.js', self::getResourcePath('js/app.js'));
		copy(__DIR__.'/tailwindcss-sass-stubs/tailwind.js', base_path('tailwind.js'));
		copy(__DIR__.'/tailwindcss-sass-stubs/resources/js/bootstrap.js', self::getResourcePath('js/bootstrap.js'));
	}

	/**
	 * @param  string  $filePath
	 * @return string
	 */
	private static function getResourcePath(string $filePath)
	{
		if (version_compare(app()->version(), '5.7.0', '>=')) {
			return resource_path($filePath);
		}

		return resource_path('assets/'.$filePath);
	}
}