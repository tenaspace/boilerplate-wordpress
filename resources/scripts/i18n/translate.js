const translate = (dictionaries) => {
  const currentLanguage = window.constants.current_language;
  if (dictionaries[currentLanguage]) {
    return dictionaries[currentLanguage];
  } else {
    return;
  }
};

export { translate };
