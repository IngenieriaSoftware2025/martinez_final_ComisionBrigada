const path = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
module.exports = {
  mode: 'development',
  entry: {
    'js/app' : './src/js/app.js',
    'js/inicio' : './src/js/inicio.js',
    'js/login/index' : './src/js/login/index.js',
    'js/usuarios/index' : './src/js/usuarios/index.js',
    'js/aplicaciones/index' : './src/js/aplicaciones/index.js',
    'js/permisos/index' : './src/js/permisos/index.js',
    'js/bienvenida/index' : './src/js/bienvenida/index.js',
    'js/asignacion/index' : './src/js/asignacion/index.js',
    'js/personal/index' : './src/js/personal/index.js',
    'js/comision/index' : './src/js/comision/index.js',
    'js/estadistica/index' : './src/js/estadistica/index.js',
    'js/mapas/index' : './src/js/mapas/index.js',
    'js/rutas/index' : './src/js/rutas/index.js',
    'js/historial/index' : './src/js/historial/index.js',
  },
  output: {
    filename: '[name].js',
    path: path.resolve(__dirname, 'public/build')
  },
  plugins: [
    new MiniCssExtractPlugin({
        filename: 'styles.css'
    })
  ],
  module: {
    rules: [
      {
        test: /\.(c|sc|sa)ss$/,
        use: [
            {
                loader: MiniCssExtractPlugin.loader
            },
            'css-loader',
            'sass-loader'
        ]
      },
      {
        test: /\.(png|svg|jpe?g|gif)$/,
        type: 'asset/resource',
      },
    ]
  }
};