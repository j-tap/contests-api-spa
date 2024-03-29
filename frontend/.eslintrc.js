module.exports = {
  root: true,
  env: {
    node: true
  },
  'extends': [
    // 'plugin:vue/essential',
    'plugin:vue/vue3-essential',
    'eslint:recommended'
  ],
  parserOptions: {
    parser: 'babel-eslint'
  },
  rules: {
    'no-console': process.env.NODE_ENV === 'production' ? 'warn' : 'off',
    'no-debugger': process.env.NODE_ENV === 'production' ? 'warn' : 'off',
    'no-dupe-class-members': 'off',
    'vue/no-multiple-template-root': 'off'
  }
}
