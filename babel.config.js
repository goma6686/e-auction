// babel.config.js
module.exports = {
  presets: [
    [
      '@babel/preset-env',
      {
        targets: 'last 2 versions',
        useBuiltIns: 'usage',
        corejs: 3,
      },
    ],
  ],
};
