import { Globals } from './globals';
import { Theme } from './theme';
import { WindowSize } from './window-size';

const Store = () => {
  Globals();
  Theme();
  WindowSize();
};

export { Store };
