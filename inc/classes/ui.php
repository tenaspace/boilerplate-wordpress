<?php
namespace TS\Inc;

use TS\Inc\Traits\Singleton;

class UI
{
  use Singleton;

  protected function __construct()
  {

  }

  /**
   * Container
   */

  public function container(string $variant = 'default')
  {
    $utils = Utils::instance();

    $variants = [
      'default' => 'lg:w-[88.88888%] lg:max-w-[1280px]',
      'fluid' => '',
    ];

    return $utils->cn('mx-auto w-full px-6', $variants[$variant]);
  }

  /**
   * Typography
   */

  public function typography(string $variant = 'default')
  {
    $variants = [
      'default' => 'text-base leading-7',
      'h1' => 'text-4xl font-extrabold tracking-tight',
      'h2' => 'text-3xl font-semibold tracking-tight',
      'h3' => 'text-2xl font-semibold tracking-tight',
      'h4' => 'text-xl font-semibold tracking-tight',
      'lead' => 'text-xl font-light',
      'large' => 'text-lg font-semibold',
      'small' => 'text-sm font-medium leading-none',
      'blockquote' => 'border-l-2 pl-6 italic',
      'inline-code' =>
        'relative rounded px-[0.3rem] py-[0.2rem] font-mono text-sm font-semibold bg-zinc-100 dark:bg-zinc-700',
    ];

    return $variants[$variant];
  }

  /**
   * Button
   */

  public function button(string $variant = 'default', string $size = 'default')
  {
    $utils = Utils::instance();

    $variants = [
      'default' => 'bg-zinc-900 text-zinc-50 hover:bg-zinc-900/90 dark:bg-zinc-50 dark:text-zinc-900 dark:hover:bg-zinc-50/90',
      'destructive' =>
        'bg-red-500 text-zinc-50 hover:bg-red-500/90 dark:bg-red-900 dark:text-zinc-50 dark:hover:bg-red-900/90',
      'outline' =>
        'border border-zinc-200 bg-white hover:bg-zinc-100 hover:text-zinc-900 dark:border-zinc-800 dark:bg-zinc-950 dark:hover:bg-zinc-800 dark:hover:text-zinc-50',
      'secondary' =>
        'bg-zinc-100 text-zinc-900 hover:bg-zinc-100/80 dark:bg-zinc-800 dark:text-zinc-50 dark:hover:bg-zinc-800/80',
      'ghost' => 'hover:bg-zinc-100 hover:text-zinc-900 dark:hover:bg-zinc-800 dark:hover:text-zinc-50',
      'link' => 'text-zinc-900 underline-offset-4 hover:underline dark:text-zinc-50'
    ];

    $sizes = [
      'default' => 'h-10 px-4 py-2',
      'sm' => 'h-9 rounded-md px-3',
      'lg' => 'h-11 rounded-md px-8',
      'icon' => 'h-10 w-10'
    ];

    return $utils->cn('inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-white transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-zinc-950 focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 dark:ring-offset-zinc-950 dark:focus-visible:ring-zinc-300', $variants[$variant], $sizes[$size]);
  }
}
?>