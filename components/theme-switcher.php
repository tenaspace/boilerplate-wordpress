<div>
  <div>
    <button x-data type='button' x-on:click="$store.theme.setTheme('light')">
      <?php echo app()->i18n->translate([
        'en' => 'Light',
        'vi' => 'Sáng',
      ]); ?>
    </button>
  </div>
  <div>
    <button x-data type='button' x-on:click="$store.theme.setTheme('dark')">
      <?php echo app()->i18n->translate([
        'en' => 'Dark',
        'vi' => 'Tối',
      ]); ?>
    </button>
  </div>
  <div>
    <button x-data type='button' x-on:click="$store.theme.setTheme('system')">
      <?php echo app()->i18n->translate([
        'en' => 'System',
        'vi' => 'Hệ thống',
      ]); ?>
    </button>
  </div>
</div>