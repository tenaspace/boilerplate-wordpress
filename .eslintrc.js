module.exports = {
  parser: '@typescript-eslint/parser',
  plugins: ['@typescript-eslint'],
  extends: ['eslint:recommended', 'plugin:@typescript-eslint/recommended'],
  env: {
    // For more environments, see here: http://eslint.org/docs/user-guide/configuring.html#specifying-environments
    browser: true,
    es6: true,
    jquery: true,
    node: true,
  },
  rules: {
    // Insert custom rules here
    // For more rules, see here: http://eslint.org/docs/rules/
    'no-invalid-this': 'off',
    'no-var': 'warn',
    'require-jsdoc': 'off',
    'no-unused-vars': 'off',
    '@typescript-eslint/no-unused-vars': 'off',
  },
  parserOptions: {
    sourceType: 'module',
  },
};
