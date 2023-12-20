const vueLoaderPath = require.resolve('vue-loader')

module.exports = {
    // ... other configurations
  
    module: {
      loaders: [
        {
          test: /\.css$/,
          loaders: ['style?insertAt=top', 'css'],
        },
      ],
      rules: [
        {
          test: /\.js$/,
          exclude: /node_modules/,
          use: {
            loader: 'babel-loader',
            options: {
              presets: ['@babel/preset-env']
            }
          }
        },
        {
            test: /\.vue$/,
            loader: vueLoaderPath,
            options: {
              compilerOptions: {
                preserveWhitespace: false
              }
            }
        }
      ]
    }
  };
  