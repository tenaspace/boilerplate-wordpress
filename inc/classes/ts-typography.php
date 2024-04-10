<?php

if (!class_exists('Ts_Typography')) {
  class Ts_Typography
  {
    private $ts_functions;

    public function __construct()
    {
      $this->ts_functions = new Ts_Functions();
    }

    public function default(...$class)
    {
      return $this->ts_functions->cn('text-base leading-7', ...$class);
    }

    public function h1(...$class)
    {
      return $this->ts_functions->cn('text-4xl font-extrabold tracking-tight', ...$class);
    }

    public function h2(...$class)
    {
      return $this->ts_functions->cn('text-3xl font-semibold tracking-tight', ...$class);
    }

    public function h3(...$class)
    {
      return $this->ts_functions->cn('text-2xl font-semibold tracking-tight', ...$class);
    }

    public function h4(...$class)
    {
      return $this->ts_functions->cn('text-xl font-semibold tracking-tight', ...$class);
    }

    public function lead(...$class)
    {
      return $this->ts_functions->cn('text-xl font-light', ...$class);
    }

    public function large(...$class)
    {
      return $this->ts_functions->cn('text-lg font-semibold', ...$class);
    }

    public function small(...$class)
    {
      return $this->ts_functions->cn('text-sm font-medium leading-none', ...$class);
    }

    public function blockquote(...$class)
    {
      return $this->ts_functions->cn('border-l-2 pl-6 italic', ...$class);
    }

    public function inline_code(...$class)
    {
      return $this->ts_functions->cn('relative rounded px-[0.3rem] py-[0.2rem] font-mono text-sm font-semibold bg-zinc-100 dark:bg-zinc-700', ...$class);
    }
  }
}

?>