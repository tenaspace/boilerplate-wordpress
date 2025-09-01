const translate = (dictionaries) => {
  const currentLanguage = window.constants.currentLanguage;
  if (dictionaries[currentLanguage]) {
    return dictionaries[currentLanguage];
  } else {
    return;
  }
};

export { translate };
