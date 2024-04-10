<?php

if (!class_exists('Ts_Container')) {
  class Ts_Container
  {
    private $ts_functions;
    private $base;

    public function __construct()
    {
      $this->ts_functions = new Ts_Functions();
      $this->base = 'mx-auto w-full px-6 sm:px-10';
    }

    public function default(...$class)
    {
      return $this->ts_functions->cn($this->base, 'md:w-[88.88888%] md:max-w-[1280px] md:px-0', ...$class);
    }

    public function fluid(...$class)
    {
      return $this->ts_functions->cn($this->base, '', ...$class);
    }
  }
}

?>