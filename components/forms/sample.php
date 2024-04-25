<?php /*
use TS\Inc\Dictionaries;
use TS\Inc\UI;

$dict = Dictionaries::instance()->get_scoped_i18n(['scope' => 'components.forms.sample']);
$ui = UI::instance();
?>

<form x-data="formSample($el)" novalidate class='space-y-4'>
  <button type="submit" class="<?php echo $ui->button(); ?>"><?php echo $dict('submit.label'); ?></button>
</form>